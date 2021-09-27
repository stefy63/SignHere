<?php

namespace App\Http\Controllers;

use App\Models\Acl;
use App\Models\Document;
use App\Models\Dossier;
use App\Models\SendDocument;
use App\Models\SendSigningDocument;
use App\Models\SignDocument;
use App\Models\SignSession;
use App\Models\TokenOtp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Exception;
use setasign\Fpdi\Fpdi;

// use App\Models\Brand;
// use App\User;

class SignController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('hasRole');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clients = Acl::getMyClients()->whereHas('dossiers', function ($qDossier) {
            $qDossier->whereExists(function ($qDocument) {
                $qDocument->select(DB::raw(1))
                    ->from('documents')
                    ->whereRaw('documents.dossier_id = dossiers.id')
                    ->where(function ($query) {
                        $query->where('signed', false)
                            ->where('readonly', false);
                    })
                    ->where('deleted_at', null)
                    ->where('active', true);
            })
                ->where('deleted_at', null);
        })->where('active', true);

        if ($request->has('clientfilter') || $request->session()->has('clientfilter')) {
            $filter = $request->has('clientfilter') ? $request->clientfilter : $request->session()->get('clientfilter');
            if ($filter !== '*') {
                $split_search = explode(' ', $filter);
                $clients = $clients->where(function ($qFilter) use ($split_search) {
                    foreach ($split_search as $part) {
                        $qFilter->whereRaw("CONCAT_WS(' ', surname, name) LIKE '%".$part."%'");
                    }
                });
                $request->session()->put('clientfilter', $filter);
            } else {
                $request->session()->forget('clientfilter', 'fo_client_page');
            }
        }

        // set pagination
        if ($request->has('client_page')) {
            $request->session()->put('fo_client_page', $request->client_page);
        }
        $client_page = $request->session()->get('fo_client_page', null);
        $clients = $clients->paginate(10, ['*'], 'client_page', $client_page);


        $archives = Acl::getMyClients()->whereHas('dossiers', function ($qDossier) {
            $qDossier->whereNotExists(function ($qDocument) {
                $qDocument->select(DB::raw(1))
                    ->from('documents')
                    ->whereRaw('documents.dossier_id = dossiers.id')
                    ->where(function ($query) {
                        $query->where('signed', false)
                            ->where('readonly', false);
                    })
                    ->where('deleted_at', null)
                    ->where('active', true);
            })
                ->whereHas('documents', function ($qDoc) {
                    $qDoc->where('date_sign', '>', Carbon::now()->subMonth(env('APP_FE_INTERVAL_MONTH')));
                })
                ->has('documents', '>', 0)
                ->where('deleted_at', null);
        })
            ->where('active', true);

        if ($request->has('archivefilter') || $request->session()->has('archivefilter')) {
            $filter = $request->has('archivefilter') ? $request->archivefilter : $request->session()->get('archivefilter');
            if ($filter !== '*') {
                $split_search = explode(' ', $filter);
                $archives = $archives->where(function ($qFilter) use ($split_search) {
                    foreach ($split_search as $part) {
                        $qFilter->whereRaw("CONCAT_WS(' ', surname, name) LIKE '%".$part."%'");
                    }
                });
                $request->session()->put('archivefilter', $filter);
            } else {
                $request->session()->forget('archivefilter', 'fo_archive_page');
            }
        }

        // set pagination
        if ($request->has('archive_page')) {
            $request->session()->put('fo_archive_page', $request->archive_page);
        }
        $archive_page = $request->session()->get('fo_archive_page', null);
        $archives = $archives->paginate(10, ['*'], 'archive_page', $archive_page);
        $sign_session = getenv('APP_SIGN_SESSION') === 'true';

        $sign_today = SignSession::whereDate('date_start', Carbon::today())->count();
        $sign_month = SignSession::whereMonth('date_start', '=', Carbon::now()->month)->count();
        $sign_prev = SignSession::whereMonth('date_start', '=', Carbon::now()->subMonth()->month)->count();
        return view('frontend.sign.index', [
            'archives' => $archives,
            'clients' => $clients,
            'sign_session' => $sign_session,
            'sign_today' => $sign_today,
            'sign_month' => $sign_month,
            'sign_prev' => $sign_prev
        ]);
    }

    /**
     * Send the Document to client.
     *
     * @return \Illuminate\Http\Response
     */
    public function send($id)
    {
        try {
            $document = Document::findOrFail($id);
            if (!Storage::disk('documents')->exists($document->filename)) {
                return redirect()->back()->with('alert', __('sign.sign_file_NOTFound'));
            }
            Mail::send(new SendDocument($document));
            return back()->with(['success' => __('sign.sign_document_send')]);

        } catch (Exception $e) {
            return back()->with(['alert' => $e->getMessage()]);
        }
    }

    /**
     * Send the Document to client.
     *
     * @return \Illuminate\Http\Response
     */
    public function signing_send($id)
    {
        $match = '/^[+|00]{0,1}[0-9]{3,4}[0-9]{6,12}$/';
        try {
            $acl_sender = Auth::user();
            $brand = $acl_sender->acls()->first()->brands()->first();
            if (!$brand->mail_templates()->first()->active) {
                return redirect()->back()->with('alert', __('sign.NO_templte_active_Found'));
            }
            $document = Document::findOrFail($id);
            if (!Storage::disk('documents')->exists($document->filename)) {
                return redirect()->back()->with('alert', __('sign.sign_file_NOTFound'));
            }
            $client = $document->dossier->client;
            $mobile = ($client->phone && !$client->mobile && preg_match($match,
                    $client->phone)) ? $client->phone : $client->mobile;
            if (!$mobile || !preg_match($match, $mobile)) {
                return redirect()->back()->with('alert', __('sign.sign_client_mobile_NOTFound'));
            }

            Mail::send(new SendSigningDocument($document));
            $token_otp = new TokenOtp();
            $token_otp->token = $acl_sender->api_token;
            $token_otp->user_id = $acl_sender->id;
            $token_otp->client_id = $client->id;
            $token_otp->phone = $mobile;
            $token_otp->document_id = $document->id;
            $token_otp->expired_time = Carbon::now()->addHour(env('APP_TOKEN_EXPIRED_TIME'));
            $token_otp->save();
            Log::info('Send mail to client: '.$client->id.' from user: '.Auth::user()->username);
            return back()->with(['success' => __('sign.signing_document_send')]);
        } catch (Exception $e) {
            Log::error('Fault from send mail to cient: '.$client->id.' with error: '.$e->getMessage());
            return back()->with(['alert' => $e->getMessage()]);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($document = Document::find($id)) {
            if (!Storage::disk('documents')->exists($document->filename)) {
                return redirect()->back()->with('alert', __('sign.sign_file_NOTFound'));
            }
            $client = $document->dossier->client->surname.'_'.$document->dossier->client->name;
            Storage::disk('documents')->move($document->filename,
                '.trash/'.$client.'-'.$document->name.'-'.Carbon::now()->toDateTimeLocalString());
            $document->delete();
            Log::info('Delete document id: '.$id.' from user: '.Auth::user()->username);

            return redirect()->back()->with('success', __('sign.success_document_deleted'));
        }
        Log::warning('Fault from deleting document id: '.$id.' with error: '.__('sign.sign_file_NOTFound'));
        return redirect()->back()->with('alert', __('sign.sign_file_NOTFound'));
    }

    /**
     * Sign the specified document.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function signing($id)
    {
        if ($document = Document::find($id)) {

            if (!Storage::disk('documents')->exists($document->filename)) {
                return redirect()->back()->with('alert', __('sign.sign_file_NOTFound'));
            }
            if ($document->signed) {
                return redirect()->back()->with('alert', __('sign.sign_doc_signed_alert').$document->date_sign);
            }
            $b64Doc = Storage::disk('documents')->get($document->filename);
            $b64Doc = base64_encode($b64Doc);

            if ($document->doctype) {
                $arrayTpl = $this->_getTemplate($document->doctype->template);
                $arrayQuestion = $this->_getTemplate($document->doctype->questions);
            } else {
                $arrayTpl = array();
                $arrayQuestion = array();
            }

            return view('frontend.sign.sign', [
                'document' => $document,
                'template' => json_encode($arrayTpl),
                'questions' => json_encode($arrayQuestion),
                'b64doc' => $b64Doc,
                'user' => Auth::user()
            ]);
        }
        return redirect()->back()->with('alert', __('sign.sign_document_NOTFound'));

    }

    public function store_signing(Request $request, $id)
    {
        $ret_url = '/sign';
        $sign_session = getenv('APP_SIGN_SESSION') === 'true';
        if ($sign_session && !SignDocument::where('document_id', $id)
                ->where('sign_session_id', session('sign_session_id'))
                ->where('signed', false)->get()) {
            Log::error('Fault from signing document id: '.$id.' with error: '.__('sign.sign_document_NOTFound'));
            return redirect()->back()->with('alert', __('sign.sign_document_NOTFound'));
        }
        if (!$request->imgB64[0]) {
            return redirect()->back()->with('alert', __('sign.document_unsigned'));
        }
        if ($document = Document::find($id)) {
            $brand = Acl::getMyBrands()->first();
            $origin = $request->imgB64[0];
            $arrayTpl = $this->_getTemplate($document->doctype->template);
            $arrayQuestion = $this->_getTemplate($document->doctype->questions);
            $base64 = ($origin) ? substr($origin, strpos($origin, ",") + 1) : '';
            $resource = base64_decode($base64);
            $returnTemplates = json_decode($request->templates);
            $returnQuestions = json_decode($request->questions);

            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile(Storage::disk('documents')->getDriver()->getAdapter()->getPathPrefix().$document->filename);
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                // import a page
                $templateId = $pdf->importPage($pageNo);
                $pdf->AddPage();
                // use the imported page and adjust the page size
                $pdf->useTemplate($templateId, ['adjustPageSize' => true]);
                $pdf->SetFont('Helvetica', 'B', 15);

                if (!is_null($returnQuestions)) {
                    foreach ($arrayQuestion as $iOptQuestion => $arItem) {
                        if ($arItem[0] == $pageNo) {
                            if ($returnQuestions[$iOptQuestion] == true) {
                                $x = $arItem[1];
                                $y = $arItem[2];
                            } else {
                                if ((int) $arItem[3] != 0) {
                                    $x = $arItem[3];
                                    $y = $arItem[4];
                                }
                            }
                            $pdf->SetXY($x, $y);
                            $pdf->Write(15, 'X');
                        }
                    }
                }

//                if(!is_null($returnTemplates)) {
                foreach ($arrayTpl as $iOptSign => $arItem) {
                    if (value($arItem[0]) == $pageNo) {
                        $x = $arItem[1];
                        $y = $arItem[2];
                        if (strtoupper($arItem[3]) != 'M') {
                            if ($returnTemplates[$iOptSign] == true) {
                                $pdf->Image($origin, $arItem[1], $arItem[2], 40, 15, 'PNG');
                            }
                        } else {
                            $pdf->Image($origin, $arItem[1], $arItem[2], 40, 15, 'PNG');
                        }
                    }
                }
//                }
            }

            $info = array(
                'Name' => ($brand->description) ? $brand->description : '',
                'Location' => $brand->city,
                'Address' => $brand->address,
                'VAT' => $brand->vat,
                'Region' => $brand->region,
                'ContactInfo' => $brand->email,
                'Document' => $document->name,
                'Client' => $document->dossier->client->surname.' '.$document->dossier->client->name,
                'ENC' => $resource,
            );

            //$finalWriter = new \SetaPDF_Core_Writer_Http('signed.pdf', true);
            $finalWriter = new \SetaPDF_Core_Writer_File(Storage::disk('documents')->getDriver()->getAdapter()->getPathPrefix().$document->filename);
            $pub_cert = file_get_contents('file://'.Storage::disk('local')->getAdapter()->getPathPrefix().'/crt/server.pem');
            $priv_cert = file_get_contents('file://'.Storage::disk('local')->getAdapter()->getPathPrefix().'/crt/server.pem');
            $reader = new \SetaPDF_Core_Reader_String($pdf->Output('S'));
            $writer = new \SetaPDF_Core_Writer_String();

            for ($i = 1; $i <= $pageCount; $i++) {
                if ($i == $pageCount) {
                    $reader = new \SetaPDF_Core_Reader_String($writer);
                    $writer = $finalWriter;
                } elseif ($i != 1) {
                    $reader = new \SetaPDF_Core_Reader_String($writer);
                    $writer = new \SetaPDF_Core_Writer_String();
                }

                $PdfDoc = \SetaPDF_Core_Document::load($reader, $writer);

                $imgReader = new \SetaPDF_Core_Reader_String($resource);
                $img = \SetaPDF_Core_Image::get($imgReader);

                $signer = new \SetaPDF_Signer($PdfDoc);

                $signer->setReason($info['Client']);
                $signer->setContactInfo($brand->description.' '.$brand->email);
                $signer->setLocation($brand->city.' '.$brand->address);
                $signer->setSignatureFieldName('Signature '.$i);

                $module = new \SetaPDF_Signer_Signature_Module_OpenSsl();

                $module->setCertificate($pub_cert);
                $module->setPrivateKey(array($priv_cert, '' /* no password */));

                $signer->addSignatureField(
                    'Signature '.$i,
                    $i,
                    \SetaPDF_Signer_SignatureField::POSITION_CENTER_BOTTOM,
                    array('x' => 0, 'y' => 70),
                    200,
                    40
                );

                $xObject = $img->toXObject($PdfDoc, \SetaPDF_Core_PageBoundaries::ART_BOX);
                $appearance = new \SetaPDF_Signer_Signature_Appearance_Dynamic($module);
                $appearance->setGraphic($xObject);
                $signer->setAppearance($appearance);
                $signer->sign($module);

            }

            $PdfDoc->getInfo()->setAll($info);
            $PdfDoc->getInfo()->setAuthor(Auth::user()->surname.' '.Auth::user()->name);
            $PdfDoc->getInfo()->SetCreator(Auth::user()->surname.' '.Auth::user()->name);
            $PdfDoc->getInfo()->setTitle($document->name);
            $PdfDoc->getInfo()->SetSubject($document->description);

            $PdfDoc->finish();
            copy($finalWriter->getPath(),
                Storage::disk('documents')->getDriver()->getAdapter()->getPathPrefix().$document->filename);
            // $pdf->Output(Storage::disk('documents')->getDriver()->getAdapter()->getPathPrefix().$document->filename,'F');
            $document->signed = true;
            $document->readonly = true;
            $document->date_sign = Carbon::now()->format('d/m/y');
            $document->user_id = Auth::user()->id;
            $document->save();
            Log::info('Signing document id: '.$id.' from user: '.Auth::user()->username);


            if ($sign_session && $request->session()->has('user.sign')) {
                SignDocument::where('document_id', $id)
                    ->where('sign_session_id', session('sign_session_id'))
                    ->update(['signed' => true]);
                if ($sign_documents = $request->session()->pull('user.sign')) {
                    $doc_id = array_pop($sign_documents);
                    session(['user.sign' => $sign_documents]);
                    $ret_url = '/sign/signing/'.$doc_id;
                } else {
                    SignSession::find(session('sign_session_id'))->update(['date_end' => Carbon::now()]);
                }
            }
            return redirect($ret_url);
        }
        Log::error('Fault from signing document id: '.$id.' with error: '.__('sign.sign_document_NOTFound'));
        return redirect()->back()->with('alert', __('sign.sign_document_NOTFound'));
    }

    protected function _getTemplate($tpl)
    {
        $tplLine = explode("\n", $tpl);
        $return = array();
        foreach ($tplLine as $line) {
            $line = str_replace("\r", '', $line);
            array_push($return, explode('|', htmlentities($line, ENT_QUOTES)));
        }

        return $return;
    }


    public function sign_session(Request $request)
    {
        $documents = json_decode($request->documents);
        $client = Acl::getMyClients()->where('active', true)->get()->pluck('id');
        if ($dossier = Dossier::where('id', $request->dossier)
            ->whereIn('client_id', $client)
            ->where('deleted_at', null)
            ->whereHas('documents', function ($qDocument) use ($documents) {
                return $qDocument->whereIn('id', $documents);
            })
            ->first()) {
            $sign_session = SignSession::create([
                'user_id' => Auth::user()->id,
                'dossier_id' => $dossier->id,
                'date_start' => Carbon::now()
            ]);
            foreach ($documents as $doc) {
                SignDocument::create([
                    'sign_session_id' => $sign_session->id,
                    'document_id' => $doc
                ]);
            }
            $doc_id = array_pop($documents);
            session(['user.sign' => $documents, 'sign_session_id' => $sign_session->id]);
            return response()->json(['url' => url('/sign/signing/'.$doc_id)], 200);
        } else {
            return response()->json(['message' => 'Error'], 500);
        }
    }


}

<?php

namespace App\Http\Controllers\Api;

use App\Models\Acl;
use App\Models\Brand;
use App\Models\Document;
use \App\Models\TokenOtp;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendDocument;
use App\Http\Controllers\Controller;
use App\Services\SMSsender;
use setasign\Fpdi\Fpdi;


class ApiSignController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Acl::getMyClients()->whereHas('dossiers', function($qDossier){
            $qDossier->whereExists(function($qDocument){
                $qDocument->select(DB::raw(1))
                    ->from('documents')
                    ->whereRaw('documents.dossier_id = dossiers.id')
                    ->where('signed',false)
                    ->whereNull('deleted_at');
            });
        })->where('active',true)->paginate(10);

        $last = Acl::getMyClients()
            ->join('dossiers','clients.id','=','dossiers.client_id')
            ->join('documents','dossiers.id','=','documents.dossier_id')
            ->orderBy('documents.date_sign','DESC')
            ->whereNotNull('date_sign')
            ->take(5)
            ->get();

        $archives = Acl::getMyClients()->whereHas('dossiers', function($qDossier){
            $qDossier->whereNotExists(function($qDocument){
                $qDocument->select(DB::raw(1))
                    ->from('documents')
                    ->whereRaw('documents.dossier_id = dossiers.id')
                    ->where('signed',false)
                    ->whereNull('deleted_at');
            });
        })->where('active',true)->paginate(10);

        return view('frontend.sign.index',[
            'archives' => $archives,
            'clients' => $clients,
            'last'   => $last,
        ]);
    }

    /**
     * Send the Document to client.
     *
     * @return \Illuminate\Http\Response
     */
    public function send($id)
    {
        try{
            $document = Document::findOrFail($id);

                Mail::send(new SendDocument($document));
                return back()->with(['success' => __('sign.sign_document_send')]);

        } catch (Exception $e){
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
        if($document = Document::findOrFail($id)){
            return response()->file(Storage::disk('public')->path('documents/'.$document->filename));
        }
        return redirect()->back()->with('error',__('sign.sign_file_NOTFound'));
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
         if ($document = Document::find($id)){
             if(!Storage::disk('documents')->exists($document->filename)){
                 return redirect()->back()->with('alert',__('sign.sign_file_NOTFound'));
             }
            Storage::disk('documents')->move($document->filename,'.trash/'.$document->name.'-'.Carbon::now()->timestamp);
            $document->delete();

            return redirect()->back()->with('success', __('sign.success_document_deleted'));
        }
        return redirect()->back()->with('alert',__('sign.sign_file_NOTFound'));
    }

    /**
     * Sign the specified document.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function signing(Request $request, $id)
    {

        if($document = Document::find($id)){
// TODO TOKEN EXPIRED CONTROL
            $now = Carbon::now();
            $tokenToOtp = TokenOtp::where('token', $request->api_token)
                    ->where('document_id',$id)
                    ->where('expired_time', '>=', $now)
                    ->get();
            if($tokenToOtp->count() == 0) {
                abort(401,__('sign.sign_token_expired'));
            }
          
            if(!Storage::disk('documents')->exists($document->filename)){
                abort(401,__('sign.sign_file_NOTFound'));
            }
            if($document->signed) {
                abort(401,__('sign.sign_doc_signed_alert').$document->date_sign);
            }
            $b64Doc = Storage::disk('documents')->get($document->filename);
            $b64Doc = base64_encode($b64Doc);
            
            if($document->doctype) {
                $arrayTpl = $this->_getTemplate($document->doctype->template);
                $arrayQuestion = $this->_getTemplate($document->doctype->questions);
            } else {
                $arrayTpl = array();
                $arrayQuestion = array();
            }

            return view('api.sign.sign',[
                'document'  => $document,
                'b64doc'    => $b64Doc,
                'template'  => json_encode($arrayTpl),
                'questions' => json_encode($arrayQuestion),
                'api_token'      => \Auth::user()->api_token
            ]);
        }
        abort(401,__('sign.sign_document_NOTFound'));

    }
       
    public function SendCode(Request $request) {
        $user = \Auth::user();
        $now = Carbon::now();
        $ret = ['message' => 'OK', 'status' => 200];
        $brand = $user->acls()->first()->brands()->first();
        if(!$tokenToOtp = TokenOtp::where('token', $user->api_token)
                    ->where('document_id',$request->document_id)
                    ->where('signed', 0)
                    ->where('expired_time', '>=', $now)
                    ->first()
        ) {
            $ret = ['message' => __('sign.sign_token_expired'), 'status' => 401];
        } else {
            if($document = Document::find($tokenToOtp->document_id)){
                if(!Storage::disk('documents')->exists($document->filename)){
                    $ret = ['message' => __('sign.sign_file_NOTFound'), 'status' => 401];
                } elseif ($document->signed) {
                    $ret = ['message' => __('sign.sign_doc_signed_alert').$document->date_sign, 'status' => 401];
                } else {
                    $msg = "Questo è il tuo codice OTP: ";
                    $SMSsender = new SMSsender();
                    if($tokenToOtp->otp = $SMSsender->Send($msg, $tokenToOtp->phone, $brand->description)) {
                        $tokenToOtp->save();
                    } else {
                        $ret = ['message' => __('sign.sign_sms_failed'), 'status' => 401];
                    }
                }
            } else {
                $ret = ['message' => __('sign.sign_document_NOTFound'), 'status' => 401];
            }
        }
        
        return response()->json($ret['message'], $ret['status']);
    }

    public function VerifyCode(Request $request) {
        $user = \Auth::user();
        $now = Carbon::now();
        $ret = ['message' => 'OK', 'status' => 200];
        $brand = $user->acls()->first()->brands()->first();
        $tokenToOtp = TokenOtp::where('token', $user->api_token)
                    ->where('document_id',$request->document_id)
                    ->where('signed', 0)
                    ->where('expired_time', '>=', $now)
                    ->first();

        if($tokenToOtp->count() == 0) {
            $ret = ['message' => __('sign.sign_token_expired'), 'status' => 401];
        } else {
            if($document = Document::find($tokenToOtp->document_id)){
                if(!Storage::disk('documents')->exists($document->filename)){
                    $ret = ['message' => __('sign.sign_file_NOTFound'), 'status' => 401];
                } elseif ($document->signed) {
                    $ret = ['message' => __('sign.sign_doc_signed_alert').$document->date_sign, 'status' => 401];
                } else {
                    $SMSsender = new SMSsender();
                    if($SMSsender->VerifyOTP($request->code, $tokenToOtp) && $this->store_signing($request, $tokenToOtp, $document)) {
                        $tokenToOtp->signed = 1;
                        $tokenToOtp->save();
                        Mail::send(new SendDocument($document));
                    } else {
                        $ret = ['message' => __('sign.sign_token_NOVerified'), 'status' => 401];
                    }
                }
            } else {
                $ret = ['message' => __('sign.sign_document_NOTFound'), 'status' => 401];
            }
        }
        return response()->json($ret['message'], $ret['status']);
    }

    public function store_signing(Request $request, $DBtoken, $document)
    {
        try {
            $brand = Acl::getMyBrands()->first();
            $resource = $DBtoken->otp;
            $arrayTpl = $this->_getTemplate($document->doctype->template);
            $arrayQuestion = $this->_getTemplate($document->doctype->questions);
            $returnTemplates = json_decode($request->templates);
            $returnQuestions = json_decode($request->questions);

            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile(Storage::disk('documents')->getDriver()->getAdapter()->getPathPrefix().$document->filename); 
            $info = array(
                'Name' => ($brand->description)?$brand->description:'',
                'Location' => $brand->city,
                'Address' => $brand->address,
                'VAT' => $brand->vat,
                'Region' => $brand->region,
                'ContactInfo' => $brand->email,
                'Document' => $document->name,
                'Client' => $document->dossier->client->surname.' '.$document->dossier->client->name,
                'OTP' => $resource,
                'Sign Time' => $DBtoken->updated_at,
                'token' => $DBtoken->token
            );
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                // import a page
                $templateId = $pdf->importPage($pageNo);
                $pdf->AddPage();
                // use the imported page and adjust the page size
                $pdf->useTemplate($templateId, ['adjustPageSize' => true]);
                $pdf->SetFont('Helvetica', 'B', 10);

                foreach ($arrayTpl as $iOptSign=>$arItem) {
                    if (value($arItem[0]) == $pageNo) {
                        $x = $arItem[1];
                        $y = $arItem[2];
                        if(strtoupper($arItem[3]) == 'M') {
                            $pdf->SetXY($x, $y+11);
                            $pdf->Write(0, $info['Client']);
                        }
                    }
                }
            }

           

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

                $signer = new \SetaPDF_Signer($PdfDoc);
                $signer->addSignatureField(
                    'Signature ' . $i,
                    $i,
                    \SetaPDF_Signer_SignatureField::POSITION_CENTER_BOTTOM,
                    array('x' => 0, 'y' => 70),
                    200,
                    40
                );
                $signer->setReason($brand->description);
                $signer->setContactInfo($brand->description.' '.$brand->email);
                $signer->setLocation($brand->city.' '.$brand->address);
                $signer->setSignatureFieldName('Signature ' . $i );
                $signer->setName($info['Client']);
                        
                $module = new \SetaPDF_Signer_Signature_Module_OpenSsl();

                $module->setCertificate($pub_cert);
                $module->setPrivateKey(array($priv_cert, ''));
                $appearance = new \SetaPDF_Signer_Signature_Appearance_Dynamic($module);
                
                $signer->setAppearance($appearance);
                $signer->sign($module);

            }

            $PdfDoc->getInfo()->setAll($info);
            $PdfDoc->getInfo()->setAuthor(\Auth::user()->surname.' '.\Auth::user()->name);
            $PdfDoc->getInfo()->SetCreator(\Auth::user()->surname.' '.\Auth::user()->name);
            $PdfDoc->getInfo()->setTitle($document->name);
            $PdfDoc->getInfo()->SetSubject($document->description);

            $PdfDoc->finish();
            copy($finalWriter->getPath(), Storage::disk('documents')->getDriver()->getAdapter()->getPathPrefix().$document->filename);
            $document->signed = true;
            $document->readonly = true;
            $document->date_sign = Carbon::now()->format('d/m/y');
            $document->user_id = \Auth::user()->id;
            $document->save();


            return true;
            
        } catch (Exception $ex) {
            return false;
        }
    }
    
    protected function _getTemplate($tpl)
    {
        $tplLine = explode("\n",$tpl);
        $return = array();
        foreach($tplLine as $line) {
            $line = str_replace("\r",'',$line);
            array_push($return,explode('|',htmlentities($line,ENT_QUOTES)));

        }
        return $return;
    }


}

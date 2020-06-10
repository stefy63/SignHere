<?php

namespace App\Http\Controllers;

use App\Models\Acl;
use App\Models\Client;
use App\Models\Doctype;
use App\Models\Document;
use App\Models\Dossier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\Auth;
use setasign\Fpdi\Fpdi;
use Spatie\PdfToText\Pdf;
use Illuminate\Support\Facades\Log;

class AdminDocumentController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
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

        // ACLS
        $acls = Acl::getMyAcls()->get();

        // CLIENTS
        // set acl
        $clients = Acl::getMyClients();
        $acl_id = $request->session()->get('acl_id', 0);
        $acl_id = $request->get('acl_id', $acl_id);
        $request->session()->put('acl_id', $acl_id);
        if ($acl_id != 0) {
          $clients = Acl::find($acl_id)->clients();
        }
        // set filter
        $clientfilter = $request->session()->get('clientfilter', '#');
        $clientfilter = $request->get('clientfilter', $clientfilter);
        $request->session()->put('clientfilter', $clientfilter);
        if($clientfilter == '#') {
          $clientfilter = '';
          $request->request->remove('client_page');
          $request->session()->forget(['clientfilter','dossierfilter','dossier_id']);
        } else {
          $clients = $clients->where(function($qFilter) use ($clientfilter) {
              $qFilter->where('surname', 'LIKE', '%'.$clientfilter.'%')
                      ->orWhere('name', 'LIKE', '%'.$clientfilter.'%');
            });
        }
        $clients = $clients->orderBy('surname', 'asc')->paginate(10, ['*'], 'client_page');
        // set client id
        $client_id = $request->session()->get('client_id', 0);
        $client_id = $request->get('client_id', $client_id);
        $request->session()->put('client_id', $client_id );


        // DOSSIERS
        // set filter
        $dossiers = Dossier::where('client_id', $client_id);
        $dossierfilter = $request->session()->get('dossierfilter', '#');
        $dossierfilter = $request->get('dossierfilter', $dossierfilter);
        $request->session()->put('dossierfilter', $dossierfilter);
        if ( $dossierfilter == '#') {
          $dossierfilter = '';
          $request->request->remove('dossier_page');
          $request->session()->forget(['dossierfilter']);
        } else {
          // dd($request->session()->all(), $request->all(), $dossierfilter);
          $dossiers = $dossiers->where('name', 'LIKE', '%'.$dossierfilter.'%');
        }
        $dossiers = $dossiers->paginate(10, ['*'], 'dossier_page');
        // set dossier_id
        $dossier_id = $request->session()->get('dossier_id', 0);
        $dossier_id = $request->get('dossier_id', $dossier_id);
        $request->session()->put('dossier_id', $dossier_id );

        // DOCUMENTS
        $documents = ($dossier_id != 0) ? Document::where('dossier_id', $request->dossier_id)->get() : array();

        if ($request->ajax()) {
          switch (true) {
            case $request->has('acl_id'):
            case $request->has('clientfilter'):
            {
            return view('admin.documents.client', [
                        'clients' => $clients
                    ])->render();
            }
            case $request->has('client_id'):
            {
              return view('admin.documents.dossier', [
                        'dossiers'      => $dossiers,
                        'dossierfilter' => $dossierfilter
                    ])->render();
            }
            case $request->has('dossier_id'):
              {
                return view('admin.documents.document', [
                          'documents' => $documents
                      ])->render();
              }
          }
        }

        return view('admin.documents.index',[
            'dossier_id'   => $dossier_id,
            'client_id'     => $client_id,
            'acl_id'        => $acl_id,
            'acls'          => $acls,
            'clients'       => $clients,
            'clientfilter'  => $clientfilter,
            'dossiers'      => $dossiers,
            'dossierfilter' => $dossierfilter,
            'documents'     => $documents,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if($dossier = Dossier::find($request->dossier_id)){
            $docTypes = Doctype::all();
            return view('admin.documents.create',[
                'dossier' => $dossier,
                'doctypes'  => $docTypes,
            ]);
        }
        return redirect()->back()->with('error', __('admin_documents.warning_document_NOTfound'));
    }

    /**
     * Store a newly created resource in documents.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, Document::$rules);

        if ($file = $request->filename) {
            $document = new Document();
            $document->fill($request->except('client_id'));
            $document->user_id = Auth::user()->id;
            $document->active = isset($request->active) ? 1 : 0;
            $document->signed = isset($request->signed) ? 1 : 0;
            $document->readonly = isset($request->readonly) ? 1 : 0;

            if($file->isValid() && $path = $file->store($request->client_id."/".$request->dossier_id,'documents')){
                $document->filename = $path;
                $template = Doctype::find($request->doctype_id);
                $pdf = new Fpdi();
                $pageCount = $pdf->setSourceFile(Storage::disk('documents')->getDriver()->getAdapter()->getPathPrefix().$document->filename);
                $templateLine = explode(PHP_EOL, $template->template);
                $tempLastPageNumber = explode('|', $templateLine[count($templateLine)-1]);

                if($tempLastPageNumber[0] && $tempLastPageNumber[0] <=  $pageCount) {
                    $document->save();
                    return redirect()->back()->with('success', __('admin_documents.success_document_created'));
                }
                unlink(Storage::disk('documents')->getDriver()->getAdapter()->getPathPrefix().$document->filename);
                Log::info('Store new document from user: '.Auth::user()->username);
                return redirect()->back()->withInput($request->input())->with('alert', __('admin_documents.warning_template_document_fault'));
            }

        }
        Log::warning('Fault from store new document with error: '.__('admin_documents.warning_document_NOTcreated'));
        return redirect()->back()->withInput($request->input())->with('warning', __('admin_documents.warning_document_NOTcreated'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Document $document, $id)
    {
        if ($document = Document::find($id)){
            $docTypes = Doctype::all();
            $dossier = $document->dossier;
            $dossiers = Dossier::where('client_id',$document->dossier->client->id)->get();

            return view('admin.documents.edit',[
                'document' => $document,
                'doctypes'  => $docTypes,
                'dossier'  => $dossier,
                'dossiers'  => $dossiers
            ]);
        }
    }

    /**
     * Update the specified resource in documents.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document, $id)
    {
        $this->validate($request, Document::$rules);

        if ($document = Document::find($id)){
            $document->fill($request->except(['client_id','filename']));
            $document->user_id = Auth::user()->id;
            $document->active = isset($request->active) ? 1 : 0;
            //$document->signed = isset($request->signed) ? 1 : 0;
            $document->readonly = isset($request->readonly) ? 1 : 0;
            if ($file = $request->file('filename')) {
                if ($file->isValid() && $path = $file->store($request->client_id . "/" . $request->dossier_id, 'documents')) {
                    $old_filename = $document->name.'-'.basename($document->filename, ".pdf");
                    if(Storage::disk('documents')->exists($document->filename)) {
                      Storage::disk('documents')->move($document->filename,'.trash/'.$old_filename);
                    }
                    $document->filename = $path;
                    $template = Doctype::find($request->doctype_id);
                    $pdf = new Fpdi();
                    $pageCount = $pdf->setSourceFile(Storage::disk('documents')->path($document->filename));
                    $templateLine = explode(PHP_EOL, $template->template);
                    $tempLastPageNumber = explode('|', $templateLine[count($templateLine)-1]);

                    if(!$tempLastPageNumber[0] || $tempLastPageNumber[0] >  $pageCount) {
                        unlink(Storage::disk('documents')->path($document->filename));
                        return redirect()->back()->withInput($request->input())->with('alert', __('admin_documents.warning_template_document_fault'));
                    }

                }
            }
            $document->save();
            Log::info('Update document id: '.$id.' from user: '.\Auth::user()->username);

            return redirect()->back()->with('success', __('admin_documents.success_document_update'));
        }
        Log::warning('Fault from updating docuennt id: '.$id.' with error: '.__('admin_documents.error_document_NOTupdate'));
        return redirect()->back()->withInput($request->input())->with('alert', __('admin_documents.error_document_NOTupdate'));

    }




    /**
     * Update the specified resource in documents.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update_file(Request $request, Document $document, $id)
    {
        if($files = $request->documents) {
            \DB::beginTransaction();
            try {
                foreach ($files as $file) {
                    if ($file->isValid() && $path = $file->store($request->client_id."/".$request->dossier_id,'documents')){
                        if(Doctype::all()->count()) {
                            $doc = new Document();
                            $doc->name = $file->getClientOriginalName();
                            $doc->date_doc = Carbon::now()->format('d/m/Y');
                            $doc->filename = $path;
                            $doc->dossier_id = $id;
                            $doc->user_id = \Auth::user()->id;
                            $doc->save();
                        } else {
                            \DB::rollBack();
                            return response()->json([
                                'error' => true,
                                'message' => __("admin_documents.notify_alert_missingDocType"),
                                'code' => 500], 500);
                        }
                    } else {
                        \DB::rollBack();
                        return response()->json([
                            'error' => true,
                            'message' => __("admin_documents.notify_alert_filesystem"),
                            'code' => 500], 500);
                    }
                }
                \DB::commit();
                return response()->json([
                    'error' => false,
                    'message' => __("admin_documents.notify_success"),
                    'code'  => 200],200);
            } catch (Exception $e) {
                \DB::rollBack();
                return response()->json([
                    'error' => true,
                    'message' => __("admin_documents.notify_alert"),
                    'code'  => 300],300);
            }
        } else {
            return response()->json([
                'error' => true,
                'message' => __("admin_documents.notify_alert"),
                'code'  => 400],400);
        }
    }

    /**
     * Remove the specified resource from documents.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document, $id)
    {
        if ($document = Document::find($id)){
            $client = $document->dossier->client->surname.'_'.$document->dossier->client->name;
            Storage::disk('documents')->move($document->filename,'.trash/'. $client . '-' .$document->name . '-' . Carbon::now()->toDateTimeLocalString());
            $document->delete();
            Log::info('Delete document id: '.$id.' from user: '.\Auth::user()->username);

            return response()->json([ __('admin_documents.success_document_deleted')],200);
        }
        Log::warning('Fault from deleting document id: '.$id.' with error: '.__('admin_documents.warning_document_NOTfound'));
        return response()->json([__('admin_documents.warning_document_NOTfound')],400);
    }



}

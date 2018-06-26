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
use Mockery\Exception;
use Illuminate\Support\Facades\Auth;
use setasign\Fpdi\Fpdi;
use Spatie\PdfToText\Pdf;

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
        $acls = Acl::getMyAcls()->get();
        if ($request->has('acl_id')) {
            $clients = ($request->acl_id == 0)?$clients = Acl::getMyClients():Acl::find($request->acl_id)->clients();
            if($request->ajax()) {
                return response()->json([$clients->get()]);
            }
        } else {
            $clients = Acl::getMyClients()->get();
        }

        if ($request->has('client_id')) {
            $dossiers = Dossier::where('client_id', $request->client_id);
            if ($request->ajax()) {
                return response()->json([$dossiers->get()]);
            }
        } else {
//            if ($clients->count()) {
//                $dossiers = Dossier::where('client_id', $clients->first()->id)->get();
//            } else {
//                return back()->with('alert',__('admin_documents.error_No_client'));
//            }
            $dossiers = array();
        }

        if ($request->has('dossier_id')) {
            $documents = Document::where('dossier_id', $request->dossier_id);
            if ($request->ajax()) {
                return response()->json([$documents->get()]);
            }
        } else {
//            if ($dossiers) {
//                $documents = Dossier::where('client_id', $dossiers->first())->get();
//            }else {
//                $documents = array();
//            }
            $documents = array();
        }

        return view('admin.documents.index',[
            'acls'      => $acls,
            'clients'   => $clients,
            'dossiers'  => $dossiers,
            'documents' => $documents,
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
                return redirect()->back()->withInput($request->input())->with('alert', __('admin_documents.warning_template_document_fault'));
            }

        }
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
            if ($file = $request->filename) {
                if ($file->isValid() && $path = $file->store($request->client_id . "/" . $request->dossier_id, 'documents')) {
                    $old_filename = $document->name.'-'.basename($document->filename, ".pdf");
                    Storage::disk('documents')->move($document->filename,'.trash/'.$old_filename);
                    $document->filename = $path;
                    $template = Doctype::find($request->doctype_id);
                    $pdf = new Fpdi();
                    $pageCount = $pdf->setSourceFile(Storage::disk('documents')->getDriver()->getAdapter()->getPathPrefix().$document->filename);
                    $templateLine = explode(PHP_EOL, $template->template);
                    $tempLastPageNumber = explode('|', $templateLine[count($templateLine)-1]);

                    if(!$tempLastPageNumber[0] && $tempLastPageNumber[0] >  $pageCount) {
                        unlink(Storage::disk('documents')->getDriver()->getAdapter()->getPathPrefix().$document->filename);
                        return redirect()->back()->withInput($request->input())->with('alert', __('admin_documents.warning_template_document_fault'));
                    }

                }
            }
            $document->save();

            return redirect()->back()->with('success', __('admin_documents.success_document_update'));
        }
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
            Storage::disk('documents')->move($document->filename,'.trash/'.$document->name . '-' . Carbon::now()->toDateTimeString());
            $document->delete();

            return response()->json([ __('admin_documents.success_document_deleted')],200);
        }
        return response()->json([__('admin_documents.warning_document_NOTfound')],400);
    }



}

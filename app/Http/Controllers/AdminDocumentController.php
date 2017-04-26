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
use Mockery\Exception;
use Illuminate\Support\Facades\Auth;

class AdminDocumentController extends Controller
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
        $acls = Acl::getMyAcls();
        if ($request->has('acl_id')) {
            $clients = Acl::find($request->acl_id)->clients();
            if($request->ajax()) {
                return response()->json([$clients->get()]);
            }
        } else {
            $clients = Acl::getMyClients();
        }

        if ($request->has('client_id')) {
            $dossiers = Dossier::where('client_id', $request->client_id);
            if ($request->ajax()) {
                return response()->json([$dossiers->get()]);
            }
        } else {
            if ($clients->count()) {
                $dossiers = Dossier::where('client_id', $clients->first()->id);
            } else {
                return back()->with('alert',__('admin_documents.error_No_client'));
            }
        }

        if ($request->has('dossier_id')) {
            $documents = Document::where('dossier_id', $request->dossier_id);
            if ($request->ajax()) {
                return response()->json([$documents->get()]);
            }
        } else {
            if ($dossiers) {
                $documents = Dossier::where('client_id', $dossiers->first());
            }else {
                $documents = array();
            }
        }



        return view('admin.documents.index',[
            'acls'      => $acls->get(),
            'clients'   => $clients->paginate(10),
            'dossiers'  => $dossiers->paginate(10),
            'documents' => $documents->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //dd($request->all());
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
        //dd($request->filename);
        if ($file = $request->filename) {
            $document = new Document();
            $document->fill($request->except('client_id'));
            $document->user_id = Auth::user()->id;
            $document->active = isset($request->active) ? 1 : 0;

            if($file->isValid() && $path = $file->store($request->client_id."/".$request->dossier_id,'documents')){
                $document->filename = $path;
            }
            $document->save();
            return redirect()->back()->with('success', __('admin_documents.success_document_created'));
        }
        return redirect()->back()->with('warning', __('admin_documents.warning_document_NOTcreated'));
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
            $dossier = $document->dossier()->first();

            return view('admin.documents.edit',[
                'document' => $document,
                'doctypes'  => $docTypes,
                'dossier'  => $dossier
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
        //dd($request->all());
        if ($document = Document::find($id)){
            $document->fill($request->except('client_id'));
            $document->user_id = Auth::user()->id;
            $document->active = isset($request->active) ? 1 : 0;
            $document->save();

            return redirect()->back()->with('success', __('admin_documents.success_document_update'));
        }
        return redirect()->back()->with('error', __('admin_documents.error_document_NOTupdate'));

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
        //dd($request->all(),documents_path('documents'));
        if($files = $request->documents) {
            \DB::beginTransaction();
            try {
                foreach ($files as $file) {
                    if ($file->isValid() && $path = $file->store($request->client_id."/".$request->dossier_id,'documents')){
                        $doc = new Document();
                        $doc->name = $file->getClientOriginalName();
                        $doc->date_doc = Carbon::now();
                        $doc->filename = $path;
                        $doc->dossier_id = $id;
                        $doc->user_id = \Auth::user()->id;
                        $doc->save();
                    } else {
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
        //dd($id);
        if ($document = Document::find($id)){
            $document->delete();

            return response()->json([ __('admin_documents.success_document_deleted')],200);
        }
        return response()->json([__('admin_documents.warning_document_NOTfound')],400);
    }
}

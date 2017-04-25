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


        return view('admin.dossier.index');
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document, $id)
    {


    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update_file(Request $request, Document $document, $id)
    {

        if($files =$request->documents) {
            \DB::beginTransaction();
            try {
                foreach ($files as $file) {
                    if ($file->isValid() && $path = $file->store('documents')){
                        $doc = new Document();
                        $doc->name = $file->getClientOriginalName();
                        $doc->date_doc = Carbon::now();
                        $doc->filename = $path;
                        $doc->dossier_id = $id;
                        $doc->user_id = \Auth::user()->id;
                        $doc->save();
                    } else {
                        return Response::json([
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
                    'code'  => 400],400);
            }
        } else {
            return response()->json([
                'error' => true,
                'message' => __("admin_documents.notify_alert"),
                'code'  => 400],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        //
    }
}

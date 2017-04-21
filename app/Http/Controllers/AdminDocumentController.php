<?php

namespace App\Http\Controllers;

use App\Models\Acl;
use App\Models\Client;
use App\Models\Document;
use App\Models\Dossier;
use Illuminate\Http\Request;

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
            $dossiers = Dossier::where('client_id',$request->client_id);
            if($request->ajax()) {
                return response()->json([$dossiers->get()]);
            }
        } else {
            $dossiers = Dossier::where('client_id',$clients->first()->id);
        }

        if ($request->has('dossier_id')) {
            $documents = Document::where('dossier_id',$request->dossier_id);
            if($request->ajax()) {
                return response()->json([$documents->get()]);
            }
        } else {
            $documents = Dossier::where('client_id',$dossiers->first());
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
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        //
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

<?php

namespace App\Http\Controllers;

use App\Models\Acl;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
    public function index()
    {
        //dd(storage_path(env('DRIVE_DOCUMENT','app/public').'/documents'),asset('storage').'/documents');
        /*$clients = Acl::getMyClients()->whereHas('dossiers', function($qDossier){
            $qDossier->whereHas('documents', function($qDocument){
                $qDocument->where('signed',false);
            });
        })->where('active',true)->paginate(10);*/


        $clients = Acl::getMyClients()->whereHas('dossiers', function($qDossier){
            $qDossier->whereExists(function($qDocument){
                $qDocument->select(DB::raw(1))
                    ->from('documents')
                    ->whereRaw('documents.dossier_id = dossiers.id')
                    ->where('signed',false)
                    ->whereNull('deleted_at');
            });
        })->where('active',true)->paginate(10);

        $archives = Acl::getMyClients()->whereHas('dossiers', function($qDossier){
            $qDossier->whereNotExists(function($qDocument){
                $qDocument->select(DB::raw(1))
                    ->from('documents')
                    ->whereRaw('documents.dossier_id = dossiers.id')
                    ->where('signed',false)
                    ->whereNull('deleted_at');
            });
        })->where('active',true)->paginate(10);




        //dd($archives);

        return view('frontend.sign.index',[
            'archives' => $archives,
            'clients' => $clients,
        ]);
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
        echo "DESTROY --> ".$id;
    }

    /**
     * Sign the specified document.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function signing($id)
    {
        if($document = Document::find($id)){
            if(!Storage::disk('documents')->exists($document->filename)){
                return redirect()->back()->with('alert',__('sign.sign_file_NOTFound'));
            }
            return view('frontend.sign.sign',[
                'document' => $document,
            ]);
        }
        return redirect()->back()->with('alert',__('sign.sign_document_NOTFound'));

    }
}

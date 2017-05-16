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

        /*$last = Acl::getMyClients()->whereHas('dossiers', function($qDossier){
            $qDossier->whereExists(function($qDocument){
                $qDocument->select(DB::raw(1))
                    ->from('documents')
                    ->whereRaw('documents.dossier_id = dossiers.id')
                    //->where('signed',false)
                    ->whereNull('deleted_at')
                    ->OrderBy('date_sign','DESC');
            });
        })->where('active',true)->take(5)->get();*/

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

        //dd($archives);

        return view('frontend.sign.index',[
            'archives' => $archives,
            'clients' => $clients,
            'last'   => $last,
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
            if($document->signed) {
                return redirect()->back()->with('alert',__('sign.sign_doc_signed_alert').$document->date_sign);
            }
            $path = storage_path('app/public/documents/').$document->filename;
            //$hash = md5_file($path);
            $b64Doc = file_get_contents($path);
            //$b64Doc = json_decode(str_replace("'", "\'", $b64Doc),true);

            if($document->doctype) {
                $arrayTpl = $this->_getTemplate($document->doctype->template);
                $arrayQuestion = $this->_getTemplate($document->doctype->questions);
            } else {
                $arrayTpl = array();
                $arrayQuestion = array();
            }


            return view('frontend.sign.sign',[
                'document' => $document,
                'template' => json_encode($arrayTpl),
                'questions' => json_encode($arrayQuestion),
                'b64doc' => $b64Doc

                //'hash' => $hash,
            ]);
        }
        return redirect()->back()->with('alert',__('sign.sign_document_NOTFound'));

    }

    public function store_signing(Request $request, $id)
    {
        dd($request->all());
        return redirect('sign');
    }

    protected function _getTemplate($tpl)
    {
        $tplLine = explode("\n",$tpl);
        $return = array();
        foreach($tplLine as $line) {
            $line = str_replace("\r",'',$line);
            array_push($return,explode('|',$line));
        }
        return $return;
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Acl;
use App\Models\Client;
use App\Models\Dossier;
use Illuminate\Http\Request;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminClientController extends Controller
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
        $Clients = Acl::getMyClients()->paginate(10);
        $acls = Acl::getMyAcls();

        return view('admin.clients.index',[
            'clients' => $Clients,
            'acls' => $acls,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $acls = Acl::getMyAcls()->get();
        return view('admin.clients.create',[
            'acls' => $acls,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Client::$rules);
        $acl_id = $request->acl_id;
        $client = new Client();
        $client->fill($request->except(['acl_id']));
        $client->user_id = Auth::user()->id;
        $client->active = isset($request->active) ? 1 : 0;
        $client->save();
        $client->acls()->sync($acl_id);
        Log::info('Store new client from user: '.\Auth::user()->username);

        return redirect()->back()->with('success', __('admin_clients.success_client_create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Client $client, $id)
    {
        if($client = Client::find($id)) {
            if($request->ajax()){
                return response()->json([$client,$client->acls->first()]);
            }
            return view('admin.clients.show',[
                'client' => $client,
            ]);
        }

        return redirect()->back()->with('warning',__( 'admin_clients.warning_client_NOTfound'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client, $id)
    {
        $acls = Acl::getMyAcls()->get();
        if($client = Client::find($id)) {
            return view('admin.clients.edit',[
                'client' => $client,
                'acls' => $acls,
            ]);
        }

        return redirect()->back()->with('warning', __('admin_clients.warning_client_NOTfound'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client, $id)
    {
        if($client = Client::find($id)) {
            if($request->ajax()){
                $client->active = $request->active;
                $client->save();
                Log::info('Update client id: '.$id.' from user: '.\Auth::user()->username);
                return response()->json(['success' => __('admin_clients.success_client_updated')]);
            }
            $this->validate($request, Client::$rules);

            $acl_id = $request->acl_id;
            $client->fill($request->except(['acl_id']));
            $client->active = isset($request->active) ? $request->active : false;
            $client->user_id = Auth::user()->id;
            $client->save();
            $client->acls()->sync($acl_id);
            Log::info('Update client id: '.$id.' from user: '.\Auth::user()->username);

            return redirect()->back()->with('success', __('admin_clients.success_client_updated'));
        }
        Log::warning('Fault from updating brand id: '.$id.' with error: '.__('admin_clients.warning_client_NOTupdated'));
        return redirect()->back()->with('warning', __('admin_clients.warning_client_NOTupdated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client, $id)
    {
        DB::beginTransaction();
        try {
            if($client = Client::find($id)) {
                if($dossiers = $client->dossiers()) {
                    foreach ($dossiers as $dossier) {
                        if ($dossier = Dossier::find($id)){
                            if($dossier->additionalDossier()) {
                                $dossier->additionalDossier()->delete();
                            }
                            foreach ($dossier->documents() as $document) {
                                Storage::disk('documents')->move($document->filename,'.trash/'.$document->name . '-' . Carbon::now()->toDateTimeString());
                            }
                            $dossier->documents()->delete();
                        }
                    }
                }
                $client->dossiers()->delete();
                $client->acls()->detach();
                $client->delete();
                DB::commit();
                Log::info('Delete client id: '.$id.' and all document, from user: '.\Auth::user()->username);
                return redirect()->back()->with('success', __('admin_clients.success_client_destroy'));
            }
            return redirect()->back()->with('warning', __('admin_clients.warning_client_NOT_deleted'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Fault from deleting client id: '.$id.' with error: '.$e->getMessage());
            return redirect()->back()->with('warning', $e->getMessage());
        }
    }
}

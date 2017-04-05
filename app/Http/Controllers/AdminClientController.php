<?php

namespace App\Http\Controllers;

use App\Models\Acl;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return view('admin.clients.index',[
            'clients' => $Clients,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.clients.create');
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

        $client = new Client();
        $client->fill($request->all());
        $client->user_id = Auth::user()->id;
        $client->active = isset($request->active) ? 1 : 0;
        $client->save();
        $client->acls()->attach(  '1');

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
                return response()->json([$client]);
            }
            return view('admin.clients.show',[
                'client' => $client,
            ]);
        }

        return redirect()->back()->with('warning', 'admin_clients.warning_client_NOTfound');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client, $id)
    {
        if($client = Client::find($id)) {
            return view('admin.clients.edit',[
                'client' => $client,
            ]);
        }

        return redirect()->back()->with('warning', 'admin_clients.warning_client_NOTfound');
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
                return response()->json(['success' => __('admin_clients.success_client_updated')]);
            }
            //dd($request->all());
            $this->validate($request, Client::$rules);

            $client->fill($request->all());
            $client->active = isset($request->active) ? $request->active : false;
            $client->user_id = Auth::user()->id;
            $client->save();


            return redirect()->back()->with('success', __('admin_clients.success_client_updated'));
        }
        return redirect()->back()->with('warning', 'admin_clients.warning_client_NOTupdated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client, $id)
    {
        if($client = Client::find($id)) {

            $client->acls()->detach();
            $client->delete();

            return redirect()->back()->with('success', __('admin_clients.success_client_destroy'));
        }
        return redirect()->back()->with('warning', 'admin_clients.warning_client_NOT_deleted');
    }
}

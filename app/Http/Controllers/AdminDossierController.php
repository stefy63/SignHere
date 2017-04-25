<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Dossier;
use Illuminate\Http\Request;

class AdminDossierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $client = Client::find($request->client_id);

        return view('admin.dossiers.create',[
            'client' => $client,
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
        $this->validate($request, Dossier::$rules);

        $dossier = new Dossier();
        $dossier->fill($request->all());
        $dossier->save();

        return redirect()->back()->with('success', __('admin_dossiers.success_dossier_created'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dossier  $dossier
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Dossier $dossier, $id)
    {
        return response()->json([dd($request->all())]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dossier  $dossier
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Dossier $dossier, $id)
    {
        //dd($request->all());
        if ($dossier = Dossier::find($id)) {
            return view('admin.dossiers.edit',[
                'dossier' => $dossier,
            ]);
        }
        return redirect()->back()->with('warning', __('admin_dossiers.warning_dossier_NOTfound'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dossier  $dossier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dossier $dossier, $id)
    {
        return response()->json([dd($request->all())]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dossier  $dossier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dossier $dossier)
    {
        //
    }
}

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
     * Store a newly created resource in documents.
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

        return redirect('admin_dossiers/'.$dossier->id.'/edit')->with('success', __('admin_dossiers.success_dossier_created'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dossier  $dossier
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Dossier $dossier, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dossier  $dossier
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Dossier $dossier, $id)
    {
        if ($dossier = Dossier::find($id)) {
            return view('admin.dossiers.edit',[
                'dossier' => $dossier,
            ]);
        }
        return redirect()->back()->with('warning', __('admin_dossiers.warning_dossier_NOTfound'));
    }

    /**
     * Update the specified resource in documents.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dossier  $dossier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dossier $dossier, $id)
    {
        $this->validate($request, Dossier::$rules);

        if ($dossier = Dossier::find($id)){
            $dossier->fill($request->all());
            $dossier->save();
            return redirect('admin_dossiers/'.$dossier->id.'/edit')->with('success', __('admin_dossiers.success_dossier_update'));
        }
        return redirect()->back()->with('warning', __('admin_dossiers.warning_dossier_NOTfound'));
    }

    /**
     * Remove the specified resource from documents.
     *
     * @param  \App\Models\Dossier  $dossier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Dossier $dossier, $id)
    {
        if ($dossier = Dossier::find($id)){
            $dossier->documents()->delete();
            $dossier->delete();
            return response()->json([ __('admin_dossiers.success_dossier_deleted')],200);
        }
        return response()->json([__('admin_dossiers.warning_dossier_NOTfound')],400);
    }

    /**
     * Export the Document to client.
     *
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request, Dossier $dossier, $id)
    {
        // return;


        $temp = Dossier::find($id);
        $client = $temp->client()->first()->toArray();
        $dossier = $temp->toArray();
        $columns = array("Fascicolo","Descrizione","Note","Data Fascicolo","Nome","Cognome","Email","PI","CF","Indirizzo","Città","Provincia","CAP","Contatto","Telefono","Cellulare");
        $data = array(
            $dossier['name'],
            $dossier['description'],
            $dossier['note'],
            $dossier['date_dossier'],
            $client['name'],
            $client['surname'],
            $client['email'],
            $client['vat'],
            $client['personal_vat'],
            $client['address'],
            $client['city'],
            $client['region'],
            $client['zip_code'],
            $client['contact'],
            $client['phone'],
            $client['mobile']
        );

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=".$client['surname']."-".$dossier['name'].".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );


        $callback = function() use ($columns, $data)
        {
            $FH = fopen('php://output', 'w');
            fputcsv($FH, $columns, chr(9));
            fputcsv($FH, $data, chr(9));
            fclose($FH);
        };


        return \Response::stream($callback, 200, $headers);
    }
}

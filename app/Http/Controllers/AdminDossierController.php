<?php

namespace App\Http\Controllers;

use App\Models\AdditionalDataDossiers;
use App\Models\Brand;
use App\Models\Client;
use App\Models\Doctype;
use App\Models\Document;
use App\Models\Dossier;
use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Array_;
use Psy\Util\Json;
use Spatie\PdfToText\Pdf;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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
        Log::info('Store new dossier from user: '.\Auth::user()->username);

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
            Log::info('Update dossier id: '.$id.' from user: '.\Auth::user()->username);
            return redirect('admin_dossiers/'.$dossier->id.'/edit')->with('success', __('admin_dossiers.success_dossier_update'));
        }
        Log::warning('Fault from updating dossier id: '.$id.' with error: '.__('admin_dossiers.warning_dossier_NOTfound'));
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
        DB::beginTransaction();
        try {
            if ($dossier = Dossier::find($id)){
                if($dossier->additionalDossier()) {
                    $dossier->additionalDossier()->delete();
                }
                foreach ($dossier->documents() as $document) {
                    Storage::disk('documents')->move($document->filename,'.trash/'.$document->name . '-' . Carbon::now()->toDateTimeString());
                }
                $dossier->documents()->delete();
                $dossier->delete();
                DB::commit();
                Log::info('Delete dossier id: '.$id.' and all document, from user: '.\Auth::user()->username);
                return response()->json([ __('admin_dossiers.success_dossier_deleted')],200);
            }
            Log::warning('Fault from deleting dossier id: '.$id.' with error: '.__('admin_dossiers.warning_dossier_NOTfound'));
            return response()->json([__('admin_dossiers.warning_dossier_NOTfound')],400);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Fault from deleting dossier id: '.$id.' with error: '.$e->getMessage());
            return response()->json([__('admin_dossiers.warning_dossier_NOTfound')],400);
        }
    }

    /**
     * Export the Document to client.
     *
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request, Dossier $dossier, $id)
    {
        $dossier = Dossier::find($id);
        $client = $dossier->client()->first()->toArray();
        $num_pratica = strstr($dossier->name, ' - ', true);
        if($aditionalDossier = AdditionalDataDossiers::where('dossier_id', $id)->first()) {
            $contraente_ragsoc = substr($aditionalDossier->note, strrpos($aditionalDossier->note, ' - ') + 3);
            $data = array_merge($client, $aditionalDossier->toArray(), (array)$num_pratica, (array)$contraente_ragsoc);
        } else {
            $data = array();
        }

        $columns = array(
            "id",
            "name" ,
            "surname" ,
            "email",
            "vat" ,
            "personal_vat" ,
            "address" ,
            "city" ,
            "region" ,
            "zip_code" ,
            "contact" ,
            "phone",
            "mobile" ,
            "user_id",
            "active" ,
            "created_at",
            "updated_at" ,
            "deleted_at" ,
            "dossier_id" ,
            "veicolo_targa" ,
            "veicolo_marca" ,
            "veicolo_modello" ,
            "veicolo_allestimento" ,
            "veicolo_cavalli_fiscali" ,
            "veicolo_valore_assicurato",
            "veicolo_stato_vaicolo",
            "veicolo_data_immatricolazione",
            "veicolo_numero_telaio",
            "contratto_polizza",
            "contratto_societa" ,
            "contratto_durata",
            "contratto_importo",
            "contratto_data_scadenza_vincolo" ,
            "contratto_data_decorrenza" ,
            "contratto_data_scadenza" ,
            "venditore",
            "incentivo",
            "note",
            "numero_pratica",
            "contraente"
        );


        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=".$client['name'].' '.$client['surname']."-".$dossier['name'].".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );


        $callback = function() use ($data, $columns)
        {
            $FH = fopen('php://output', 'w');
            fputcsv($FH, $columns, chr(9));
            fputcsv($FH, $data, chr(9));
            fclose($FH);
        };


        return \Response::stream($callback, 200, $headers);
    }

    /**
     * Remove the specified resource from documents.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import_file(Request $request)
    {
        $return = shell_exec(sprintf("which %s", escapeshellarg('pdftotext')));
        if(empty($return)){
            return response()->json([
                'error' => true,
                'message' => __("admin_documents.notify_alert_command_shell"),
                'code' => 500], 500);
        };

        if($files = $request->documents) {
            //\DB::beginTransaction();
            try {
//                $file = $files[0];
                $file = $request->file('documents')[0];
                if ($file->isValid()){
                    //$text = Pdf::getText($file->getPathName(), '/usr/local/bin/pdftotext');
                    $text = (new Pdf(preg_replace('/\s+/', ' ', trim($return))))
                        ->setPdf($file->getPathName())
                        ->setOptions(['f 1', 'l 1'])
                        ->text();
                    $retTextImport = Array();
                    $arTextFile = explode(PHP_EOL, $text);
                    $temp = $this->_searchVal($arTextFile, 'GLOBAL SAFE INSURANCE BROKER SRL', 1);
                    if(stripos($temp[0], 'GS_Cop') === false){
                        return response()->json([
                            'error' => true,
                            'message' => __("admin_documents.model_fault"),
                            'code'  => 300],300);
                    }

                    $pos_targa = array_search('Dati del Veicolo', $arTextFile,true);

                    $temp = $this->_searchVal($arTextFile, 'Pratica n°', 2);
                    // DATI CONTRAENTE/ASSICURATO
                    $temp = $this->_searchVal($arTextFile, 'Nome', 6);
                    $retTextImport['contName'] = [(stripos($temp[5], 'Cognome') === false)?'':$temp[1], '', 10];
                    $retTextImport['name'] = [(stripos($temp[5], 'Cognome') === false)?$temp[1]:$temp[3], '', 1];

                    $tmp = array_keys(array_filter($arTextFile, function($el) {
                        return str_contains($el, "Cognome/Ragione Soc.");
                    }));
                    $surname = $arTextFile[$tmp[0] + 2];
                    $retTextImport['contSurname'] = [$surname, '', 11];
                    $retTextImport['surname'] = [$surname, '', 2];
                    $temp = $this->_searchVal($arTextFile, 'Indirizzo', 4);
                    $retTextImport['contAddress'] = [$temp[1], '', 12];
                    $retTextImport['address'] = [$temp[3], '', 3];
                    $temp = $this->_searchVal($arTextFile, 'Località', 4);
                    $retTextImport['contLoc'] = [$temp[1], '', 13];
                    $retTextImport['city'] = [$temp[3], '', 4];
                    $temp = $this->_searchVal($arTextFile, 'CAP - Provincia', 2);
                    $retTextImport['contCAP'] = [$temp[1], '', 14];
                    $tempFax = $this->_searchVal($arTextFile, 'Fax', 15);
                    $retTextImport['zip_code'] = [(stripos($tempFax[14], 'Targa') === false)?$tempFax[5]:$tempFax[7], '', 5];
                    $retTextImport['contPR'] = [(stripos($tempFax[14], 'Targa') === false)?$tempFax[3]:$tempFax[5], '', 16];
                    $retTextImport['region'] = [(stripos($tempFax[14], 'Targa') === false)?$tempFax[7]:$tempFax[9], '', 6];
                    $temp = $this->_searchVal($arTextFile, 'Codice Fiscale/P.IVA', 4);
                    $retTextImport['contCFPIVA'] = [strtoupper($temp[1]), '', 17];
                    if (stripos($temp[3], 'lefono/Cellul') === false) {
                        $retTextImport['personal_vat'] = [strtoupper($temp[3]), '', 7];
                    } else {
                        $retTextImport['personal_vat'] = [$arTextFile[$pos_targa - 6], '', 7];
                    }

                    $temp = $this->_searchVal($arTextFile, 'Telefono/Cellulare', 4);
                    $retTextImport['contTel'] = [strtolower($temp[1]), '', 18];

                    if (stripos($temp[3], 'email') === false) {
                        $retTextImport['phone'] = [strtolower($temp[3]), '', 8];
                    } else {
                        $retTextImport['phone'] = ['', '', 8];;
                    }

                    $temp = $this->_searchVal($arTextFile, 'Email', 4);
                    $retTextImport['contEmail'] = [strtolower($temp[1]), '', 19];

                    if (stripos($temp[3], 'fax') === false) {
                        $retTextImport['email'] = [strtolower($temp[3]), '', 9];
                    } else {
                        $retTextImport['email'] = [$arTextFile[$pos_targa - 4], '', 9];
                    }

                    // DATI VICOLO
                    $retTextImport['veicleSummary'] = [$arTextFile[$pos_targa - 2], '', 30];
                    $temp = $this->_searchVal($arTextFile, 'Targa', 2);
                    $retTextImport['veicolo_targa'] = [$temp[1], '', 31];
                    $temp = $this->_searchVal($arTextFile, 'Valore assicurato', 2);
                    $retTextImport['veicolo_valore_assicurato'] = [$temp[1], '', 32];
                    $temp = $this->_searchVal($arTextFile, 'Marca', 2);
                    $retTextImport['veicolo_marca'] = [$temp[1], '', 33];
                    $temp = $this->_searchVal($arTextFile, 'Stato veicolo', 2);
                    $retTextImport['veicolo_stato_vaicolo'] = [$temp[1], '', 34];
                    $temp = $this->_searchVal($arTextFile, 'Modello', 2);
                    $retTextImport['veicolo_modello'] = [$temp[1], '', 35];
                    $temp = $this->_searchVal($arTextFile, 'Data prima immatr.', 2);
                    $retTextImport['veicolo_data_immatricolazione'] = [$temp[1], '', 36];
                    $temp = $this->_searchVal($arTextFile, 'Allestimento', 2);
                    $retTextImport['veicolo_allestimento'] = [$temp[1], '', 37];
                    $temp = $this->_searchVal($arTextFile, 'Numero di telaio', 2);
                    $retTextImport['veicolo_numero_telaio'] = [$temp[1], '', 38];
                    $temp = $this->_searchVal($arTextFile, 'Cavalli Fiscali', 2);
                    $retTextImport['veicolo_cavalli_fiscali'] = [$temp[1], '', 39];
                    // DATI CONTRATTO
                    $temp = $this->_searchVal($arTextFile, 'Dati del Contratto', 2);
                    $retTextImport['contractSummary'] = [$temp[1], '', 50];
                    $temp = $this->_searchVal($arTextFile, 'Polizza', 2);
                    $retTextImport['contratto_polizza'] = [$temp[1], '', 51];
                    $temp = $this->_searchVal($arTextFile, 'Società vincolataria', 2);
                    $retTextImport['contratto_societa'] = [(stripos($temp[1], 'copertura') === false)?$temp[1]:'', '', 52];
                    $temp = $this->_searchVal($arTextFile, 'Durata copertura', 2);
                    $retTextImport['contratto_durata'] = [$temp[1], '', 53];
                    $temp = $this->_searchVal($arTextFile, 'Data scad. vincolo', 2);
                    $retTextImport['contratto_data_scadenza_vincolo'] = [(stripos($temp[1], 'decorrenza') === false)?$temp[1]:'', '', 54];
                    $temp = $this->_searchVal($arTextFile, 'Data decorrenza', 2);
                    $retTextImport['contratto_data_decorrenza'] = [$temp[1], '', 55];
                    $temp = $this->_searchVal($arTextFile, 'Data scadenza', 2);
                    $retTextImport['contratto_data_scadenza'] = [$temp[1], '', 56];
                    $temp = $this->_searchVal($arTextFile, 'Importo Totale', 2);
                    $retTextImport['contratto_importo'] = [$temp[1], '', 57];
                    $path = $file->store('/', 'documents');
                    $retTextImport['temp_name'] = [$path , '', 100];

                    $this->_setLabel($retTextImport);

                    $retTextImport = collect($retTextImport)->sortBy([2])->toArray();

                    // \Storage::disk('documents')->put($retTextImport['dossierNumber'].'-imported.pdf', $text);

                    Log::info('Import file from user: '.Auth::user()->username);
                    return response()->json(['message1' => $retTextImport]);

                } else {
                    //\DB::rollBack();
                    Log::error('Error from import file with error: '.__("admin_documents.notify_alert_filesystem"));
                    return response()->json([
                        'error' => true,
                        'message' => __("admin_documents.notify_alert_filesystem"),
                        'code' => 500], 500);
                }
            } catch (Exception $e) {
                //\DB::rollBack();
                Log::error('Error from import file with error: '.__("admin_documents.notify_alert"));
                return response()->json([
                    'error' => true,
                    'message' => __("admin_documents.notify_alert"),
                    'code'  => 300],300);
            }
        } else {
            Log::error('Error from import file with error: '.__("admin_documents.notify_alert"));
            return response()->json([
                'error' => true,
                'message' => __("admin_documents.notify_alert"),
                'code'  => 400],400);
        }
    }

    public function update_import_file(Request $request) {

        if(!$brand = Brand::where('vat', $request->contCFPIVA)
                        ->orWhere('personal_vat', $request->contCFPIVA)->first()) {
            return redirect()->back()->with('alert', __('admin_dossiers.alert_contractor_NOTfound'));
        }
        if(!$acl = $brand->acls()->first()) {
            return redirect()->back()->with('alert', __('admin_dossiers.alert_visibiity_NOTfound'));
        }

        \DB::beginTransaction();
        if(!$client = Client::where('vat', $request->personal_vat)
            ->orWhere('personal_vat', $request->personal_vat)->first()) {
            $client = new Client();
            $client->fill($request->all());
            $client->mobile = $client->phone;
            $client->personal_vat = '';
            if(preg_match("/^[0-9]{11}$/i", $request->personal_vat)){
                $client->vat = $request->personal_vat;
            } else {
                $client->personal_vat = $request->personal_vat;
            }
            $client->active = true;
            $client->user_id = \Auth::user()->id;
            $client->save();
            $client->acls()->attach($acl);
        }
        $clientAlcs = $client->acls()->get()->pluck(['id']);
        if(!in_array($acl->id, $clientAlcs->all())) {
            $client->acls()->attach($acl);
        }
        if($existDossier = Dossier::where('name', 'LIKE', $request->dossierNumber.' -%')->first()) {
            \DB::rollBack();
            Log::error('Errore from store iported file with error: '.__('admin_dossiers.alert_existent_dossier'));
            return redirect()->back()->with('alert', __('admin_dossiers.alert_existent_dossier'));
        }
        $dossier = new Dossier();
        $dossier->name = $request->dossierNumber.' - '.$request->veicleSummary;
        $dossier->client_id = $client->id;        
        if (!$dossier->save()) {
            \DB::rollBack();
            Log::error('Errore from store iported file with error: '.__('admin_dossiers.alert_create_dossier'));
            return redirect()->back()->with('alert', __('admin_dossiers.alert_create_dossier'));
        }
        $additionaDossier = new AdditionalDataDossiers();
        $additionaDossier->fill($request->all());
        $additionaDossier->dossier_id = $dossier->id;
        $additionaDossier->venditore = $request->venditore;
        $additionaDossier->note = $request->note. ' - '. $request->contSurname;
        $additionaDossier->incentivo = $request->incentivo;
        if (!$additionaDossier->save()) {
            \DB::rollBack();
            Log::error('Errore from store iported file with error: '.__('admin_dossiers.alert_create_dossier'));
            return redirect()->back()->with('alert', __('admin_dossiers.alert_create_dossier'));
        }

        if(\Storage::disk('documents')->exists($request->temp_name)) {
             // $file = \Storage::disk('documents')->get($request->temp_name);
            \Storage::disk('documents')->move($request->temp_name, $client->id."/".$dossier->id."/".$request->temp_name);
        }

        $document = new Document();
        $document->name = 'CONFERMA COPERTURA POLIZZA ASSICURATIVA';
        $document->filename = $client->id."/".$dossier->id."/".$request->temp_name;
        $docType = Doctype::where('description', 'GS_Cop v2.7')->first();
        $document->doctype_id = ($docType) ? $docType->id : 1;
        $document->dossier_id = $dossier->id;
        $document->user_id = \Auth::user()->id;
        $document->active = 1;
        $document->signed = 0;
        $document->readonly = 0;        
        if (!$document->save()) {
            \DB::rollBack();
            Log::error('Errore from store iported file with error: '.__('admin_dossiers.alert_create_dossier'));
            return redirect()->back()->with('alert', __('admin_dossiers.alert_create_dossier'));
        }
        \DB::commit();
        Log::info('Store imported file from user: '.Auth::user()->username);
        return redirect('admin_documents')->with('success', __('admin_dossiers.success_import'));
    }

    private function _searchVal($array, $search, $numField = 1) {
        return array_slice($array, array_search($search, $array,true)+1, $numField);
    }

    private function _setLabel(& $array) {
        foreach ($array as $key => $val) {
            $array[$key][1] = trans('admin_dossiers.'.$key);
        }
    }
}

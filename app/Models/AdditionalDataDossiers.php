<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdditionalDataDossiers extends Model
{

    protected $guarded = array();
    protected $fillable = [
        'dossier_id',
        'veicolo_targa',
        'veicolo_marca',
        'veicolo_modello',
        'veicolo_allestimento',
        'veicolo_cavalli_fiscali',
        'veicolo_valore_assicurato',
        'veicolo_stato_vaicolo',
        'veicolo_data_immatricolazione',
        'veicolo_numero_telaio',
        'contratto_polizza',
        'contratto_societa',
        'contratto_durata',
        'contratto_importo',
        'contratto_data_scadenza_vincolo',
        'contratto_data_decorrenza',
        'contratto_data_scadenza',
        'note'
    ];



    protected $table = 'additional_data_dossiers';

    use SoftDeletes;

}

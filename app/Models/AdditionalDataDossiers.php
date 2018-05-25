<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdditionalDataDossiers extends Model
{

    protected $guarded = array();
    protected $fillable = ['*'];

    protected $table = 'additional_data_dossiers';

    use SoftDeletes;

    public static $rules = array(
        'name'          => 'required',
    );
}

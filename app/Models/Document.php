<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Acl;
use App\Models\Doctype;
use App\Models\Client;

class Document extends Model
{
    protected $guarded = array();
    //protected $fillable = ['*'];


    public static $rules = array(
        'name'      => 'required',
    );

    public function doctype() {
        return $this->hasOne(Doctype::class);
    }

    public function dossier() {
        return $this->hasOne(Dossier::class);
    }
}

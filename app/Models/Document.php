<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Acl;
use App\Models\Doctype;
use App\Models\Client;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    protected $guarded = array();
    //protected $fillable = ['*'];

    use SoftDeletes;

    public static $rules = array(
        'name'      => 'required',
        'filename'  => 'required',
    );

    public function doctype() {
        return $this->belongsTo(Doctype::class);
    }

    public function dossier() {
        return $this->belongsTo(Dossier::class);
    }
}

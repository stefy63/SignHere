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
        //data'filename'  => 'required',
    );

    public function doctype() {
        return $this->belongsTo(Doctype::class);
    }

    public function dossier() {
        return $this->belongsTo(Dossier::class);
    }

    public function getDateDocAttribute($value)
    {
        return $this->__getData($value);
    }

    public function setDateDocAttribute($value)
    {
        $this->attributes['date_doc'] = $this->__setData($value);
    }

    private function __getData($data)
    {
        $tmpdate = $data;
        if ($tmpdate == "0000-00-00" || $tmpdate == "") {
            return "";
        } else {
            return date('d/m/Y',strtotime($tmpdate));
        }
    }

    public function __setData($data) {
        if ($data) {
            return preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$data);
        } else {
            return '';
        }
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dossier extends Model
{
    protected $guarded = array();
    protected $fillable = ['id','name','description','date_dossier','client_id','note'];


    use SoftDeletes;

    public static $rules = array(
        'name'      => 'required',
        'date_dossier'      => 'required|date_format:"d/m/Y"',
    );

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function documents(){
        return $this->hasMany(Document::class);
    }


    public function getDateDossierAttribute($value)
    {
        return $this->__getData($value);
    }

    public function setDateDossierAttribute($value)
    {
        $this->attributes['date_dossier'] = $this->__setData($value);
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

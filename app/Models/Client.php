<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Acl;
use App\Models\Document;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    protected $guarded = array();
    //protected $fillable = ['*'];

    use SoftDeletes;

    public static $rules = array(
        'name'      => 'required',
        'email'     => 'required|email',
        'acl_id'    => 'required|array',
        'vat'       => 'nullable|required_without:surname|digits: 11',
        'personal_vat' => 'nullable|required_with:surname|regex:/^[A-Za-z]{6}[0-9LMNPQRSTUV]{2}[A-Za-z]{1}[0-9LMNPQRSTUV]{2}[A-Za-z]{1}[0-9LMNPQRSTUV]{3}[A-Za-z]{1}$/'
    );

    public function acls() {
        return $this->belongsToMany(Acl::class);
    }

    public function dossiers() {
        return $this->hasMany(Dossier::class);
    }

    public function documents() {
        return $this->hasMany(Dossier::class)->with('documents');
    }
}

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


    public function acls() {
        return $this->belongsToMany(Acl::class,'document_acl');
    }

    public function doctypes() {
        return $this->hasOne(Doctype::class);
    }

    public function clients() {
        return $this->hasOne(Client::class);
    }
}

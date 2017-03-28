<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Acl;
use App\Models\Document;

class Client extends Model
{
    protected $guarded = array();
    //protected $fillable = ['*'];


    public function acls() {
        return $this->belongsToMany(Acl::class,'client_acl');
    }

    public function documents() {
        return $this->hasMany(Document::class);
    }
}

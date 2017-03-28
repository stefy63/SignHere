<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Acl;

class Location extends Model
{
    protected $guarded = array();
    //protected $fillable = ['*'];


    public function acls() {
        return $this->belongsToMany(Acl::class,'location_acl');
    }
}

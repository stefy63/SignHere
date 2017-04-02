<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Acl;

class Device extends Model
{
    protected $guarded = array();
    //protected $fillable = ['*'];


    public function acls() {
        return $this->belongsToMany(Acl::class,'device_acl');
    }

    public function user() {
        return $this->belongsToMany(User::class,'device_user');
    }
}

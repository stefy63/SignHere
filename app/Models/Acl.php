<?php

namespace App\models;

use App\User;
use App\Models\Device;
use App\Models\Location;
use App\Models\Document;
use App\Models\Client;
use Illuminate\Database\Eloquent\Model;

class Acl extends Model
{
    protected $guarded = array();
    //protected $fillable = ['*'];

    public function devices(){
        return $this->belongsToMany(Device::class,'device_acl');
    }

    public function brands(){
        return $this->belongsToMany(Brand::class,'brand_acl');
    }

    public function locations(){
        return $this->belongsToMany(Location::class,'location_acl');
    }

    public function documents(){
        return $this->belongsToMany(Document::class,'document_acl');
    }

    public function clients(){
        return $this->belongsToMany(Client::class,'client_acl');
    }

    public function users(){
        return $this->belongsToMany(User::class,'user_acl');
    }

}

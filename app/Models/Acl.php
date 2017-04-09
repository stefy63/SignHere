<?php

namespace App\models;

use App\Models\User;
use App\Models\Device;
use App\Models\Location;
use App\Models\Document;
use App\Models\Client;
use App\Models\Brand;
use App\Models\brand_acl;
use App\Models\user_acl;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public static function getMyBrands() {
        $userAcls = \Auth::user()->getMyAcls();
        $Brands = Brand::whereHas('acls',function ($q) use ($userAcls){
            $q->whereIn('acl_id',$userAcls);
        });
        return $Brands;
    }

    public static function getMyLocations() {
        $userAcls = \Auth::user()->getMyAcls();
        $Locations = Location::whereHas('acls',function ($q) use ($userAcls){
            $q->whereIn('acl_id',$userAcls);
        });
        return $Locations;
    }

    public static function getMyUsers() {
        $userAcls = \Auth::user()->getMyAcls();
        $Users = User::whereHas('acls',function ($q) use ($userAcls){
            $q->whereIn('acl_id',$userAcls);
        });
        return $Users;
    }

    public static function getMyDevices() {
        $userAcls = \Auth::user()->getMyAcls();
        $Devices = Device::whereHas('acls',function ($q) use ($userAcls){
            $q->whereIn('acl_id',$userAcls);
        });
        return $Devices;
    }

    public static function getMyClients() {
        $userAcls = \Auth::user()->getMyAcls();
        $Clients = Client::whereHas('acls',function ($q) use ($userAcls){
            $q->whereIn('acl_id',$userAcls);
        });
        return $Clients;
    }

    public static function getMyDocuments() {
        $userAcls = \Auth::user()->getMyAcls();
        $Documents = Document::whereHas('acls',function ($q) use ($userAcls){
            $q->whereIn('acl_id',$userAcls);
        });
        return $Documents;
    }

    public static function getMyAcls() {
        $userAcls = \Auth::user()->getMyAcls();
        $acls = Acl::whereHas('users',function ($q) use ($userAcls){
            $q->whereIn('acl_id',$userAcls);
        });

        return $acls;
    }

    /*public static function getMyModules() {
        $userAcls = \Auth::user()->getMyAcls();
        $Modules = Module::whereHas('acls',function ($q) use ($userAcls){
            $q->whereIn('acl_id',$userAcls);
        });
        return $Modules;
    }*/
}

<?php

namespace App\models;

use App\Models\User;
use App\Models\Device;
use App\Models\Location;
use App\Models\Document;
use App\Models\Client;
use App\Models\Brand;
use App\Models\Profile;
use App\Models\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Acl extends Model
{
    protected $guarded = array();
    //protected $fillable = ['*'];

    use SoftDeletes;

    public static $rules = array(
        'name'          => 'required',
        'brand_id'      => 'required|integer',
        'acl_id'        => 'required|integer'
    );

    public function devices(){
        return $this->belongsToMany(Device::class);
    }

    public function brands(){
        return $this->belongsToMany(Brand::class);
    }

    public function locations(){
        return $this->belongsToMany(Location::class);
    }

    public function clients(){
        return $this->belongsToMany(Client::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function profiles(){
        return $this->belongsToMany(Profile::class);
    }

    public function module(){
        return $this->belongsToMany(Module::class);
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

    /*public static function getMyDocuments() {
        $userAcls = \Auth::user()->getMyAcls();
        $Documents = Document::whereHas('acls',function ($q) use ($userAcls){
            $q->whereIn('acl_id',$userAcls);
        });
        return $Documents;
    }*/

    public static function getMyAcls() {
        $userAcls = \Auth::user()->getMyAcls();
        $acls = Acl::whereIn('id',$userAcls);

        return $acls;
    }

    public static function getMyProfiles() {
        $userAcls = \Auth::user()->getMyAcls();
        $Modules = Profile::whereHas('acls',function ($q) use ($userAcls){
            $q->whereIn('acl_id',$userAcls);
        });
        return $Modules;
    }

    public static function getMyModules() {
        $userAcls = \Auth::user()->getMyAcls();
        $Modules = Module::whereHas('acls',function ($q) use ($userAcls){
            $q->whereIn('acl_id',$userAcls);
        });
        return $Modules;
    }
}

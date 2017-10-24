<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Acl;
use App\Models\Brand;
use Illuminate\Database\Eloquent\SoftDeletes;


class Location extends Model
{
    protected $guarded = array();
    //protected $fillable = ['*'];

    use SoftDeletes;

    public static $rules = array(
        'brand_id'          => 'required|integer',
        'description'       => 'required',
        'address'           => 'required',
        'city'              => 'required',
        'region'            => 'required',
        'email'             => 'required|email',
    );


    public function acls() {
        return $this->belongsToMany(Acl::class);
    }

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }
}

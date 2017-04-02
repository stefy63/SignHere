<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Acl;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    protected $guarded = array();
    //protected $fillable = ['*'];

    use SoftDeletes;

    public static $rules = array(
        'description'       => 'required',
        'vat'               => 'required|numeric',
        'address'           => 'required',
        'city'              => 'required',
        'region'            => 'required',
        'email'             => 'required|email',
    );

    public function acls() {
        return $this->belongsToMany(Acl::class,'brand_acl');
    }

    public function locations() {
        return $this->hasMany(Location::class);
    }

}

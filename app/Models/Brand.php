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
        'vat'               => 'required|digits: 11',
        'address'           => 'required',
        'city'              => 'required',
        'region'            => 'required',
        'email'             => 'required|email',
        'smtp_host'         => 'required',
        'smtp_port'         => 'required|integer',
        'smtp_username'     => 'required',
        'smtp_password'     => 'required',
    );

    public function acls() {
        return $this->belongsToMany(Acl::class);
    }

    public function locations() {
        return $this->hasMany(Location::class);
    }

     public function mail_templates() {
        return $this->hasOne(MailTemplate::class);
    }
    
}

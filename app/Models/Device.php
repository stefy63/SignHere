<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Acl;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    protected $guarded = array();
    //protected $fillable = ['*'];

    use SoftDeletes;

    public static $rules = array(
        'description'       => 'required',
        'serial'            => 'required',
        //'user_id'       => 'required|min:1',
    );

    public function acls() {
        return $this->belongsToMany(Acl::class,'device_acl');
    }

    public function user() {
        return $this->belongsToMany(User::class,'device_user');
    }
}

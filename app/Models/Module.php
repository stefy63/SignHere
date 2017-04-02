<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $guarded = array();
    //protected $fillable = ['*'];

    public function users(){
         return $this->belongsToMany(User::class,'user_module')->withPivot('permission');
    }
}

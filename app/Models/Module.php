<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    protected $guarded = array();
    //protected $fillable = ['*'];

    use SoftDeletes;

    public static $rules = array(
        'name'       => 'required',
        'short_name' => 'required',
        'functions'  => 'required',
    );

    public function users(){
         return $this->belongsToMany(User::class,'user_module')->withPivot('permission');
    }
}

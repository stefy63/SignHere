<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Module extends Model
{
    protected $guarded = array();
    //protected $fillable = ['*'];

    use SoftDeletes;

    public static function rules($id = false) {

        return array(
            'name'       => 'required',
            'short_name' => 'required'.($id)?'|unique:modules,short_name,'.$id:"|unique:modules,short_name",
            'functions'  => 'required',
        );
    }

    public function users(){
         return $this->belongsToMany(User::class)->withPivot('permission');
    }

    public function profiles(){
         return $this->belongsToMany(Profile::class)->withPivot('permission');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    protected $guarded = array();
    //protected $fillable = ['*'];

    use SoftDeletes;

    public static $rules = array(
        'name'          => 'required',
    );

    public function users() {
        return $this->hasMany(Profile::class);
    }

    public function modules() {
        return $this->belongsToMany(Module::class,'module_profile')->withPivot('permission');
    }

    public function getModules($module = false) {

        $result = $this->modules()
            ->where('active',true);

        if($module) $result = $result->where('short_name',$module);

        return $result->get();
    }

}
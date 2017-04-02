<?php

namespace App;

use App\Models\Acl;
use App\Models\Device;
use App\Models\Module;
use App\Models\user_acl;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = array();
    //protected $fillable = ['*'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static $rules = array(
            'username'  =>'required',
            'password'  =>'required|alpha_num|between:6,12',
            'email'     => 'required|email',
        );

    public static $rules_change_pwd = array(
            'password'                  =>'required',
            'new_password'              =>'required|alpha_num|between:6,12',
            'new_password_confirmation' =>'required|same:new_password'
        );


    public function modules() {
        return $this->belongsToMany(Module::class,'user_module')->withPivot('permission');
    }

    public function acls() {
        return $this->belongsToMany(Acl::class,'user_acl');
    }


    public function devices() {
        return $this->belongsToMany(Device::class,'device_user');
    }

    public function getModules($module = false) {

        $result = $this->modules()
            ->where('active',true);

        if($module) $result = $result->where('short_name',$module);

        return $result->get();
    }

    public function isAdmin() {
        return $this->modules()
                ->where('active',true)
                ->where('isadmin',true)
                ->get()->count();
    }
    
    /**
    * Find out if user has a specific role
    *
    * $return boolean
    */
    public function hasRole($module, $op)
    {
        if($userPermission = $this->getModules($module))
        {
            $userPermission = $userPermission->first();
            //dd($userPermission->functions);
            ($userPermission->pivot->permission != 'ALL')? :$userPermission->pivot->permission = $userPermission->functions;
            (!str_contains($op, 'store'))? :$op='create';
            (!str_contains($op, 'update'))? :$op='edit';

            return (strpos(" ".$userPermission->pivot->permission,$op )>0 ? true : false);
        }
        return false;
    }

    public function getMyAcls() {
        return $this->acls()->get()->pluck('id')->toArray();
    }

}

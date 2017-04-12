<?php

namespace App\Models;

use App\Models\Acl;
use App\Models\Device;
use App\Models\Module;
use App\Models\user_acl;
use App\Models\Profile;
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
            'password'  =>'required|alpha_num|between:5,12',
            'email'     => 'required|email',
        );

    public static $rules_change_pwd = array(
            'password'                  =>'required',
            'new_password'              =>'required|alpha_num|between:5,12',
            'new_password_confirmation' =>'required|same:new_password'
        );


    public function modules() {
        return $this->belongsToMany(Module::class,'user_module')->withPivot('permission');
    }

    public function acls() {
        return $this->belongsToMany(Acl::class,'user_acl');
    }

    public function profile() {
        return $this->belongsTo(Profile::class);
    }

    public function devices() {
        return $this->belongsToMany(Device::class,'device_user');
    }

    public function isAdmin() {
        $profile = Profile::where('id',$this->profile_id)->first()->modules();

        return $profile
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
        if($userPermission = $this->profile()->first()->getModules($module))
        {
            $userPermission = $userPermission->first();
            ($userPermission->pivot->permission != 'ALL')? :$userPermission->pivot->permission = $userPermission->functions;
            if(str_contains($op,'_')) {
                list($op,$suf) = explode('_',$op,2);
                if(str_contains($op, 'store') || str_contains($op, 'update')) {
                    $op=$suf;
                }
            } else {
                (!str_contains($op, 'store'))? :$op='create';
                (!str_contains($op, 'update'))? :$op='edit';
            }
            return (strpos(" ".$userPermission->pivot->permission,$op )>=0 ? true : false);
        }
        return false;
    }

    public function getMyAcls() {
        return $this->acls()->get()->pluck('id')->toArray();
    }

}

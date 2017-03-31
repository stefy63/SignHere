<?php

namespace App;

use App\Models\Acl;
use App\Models\Module;
use App\Models\user_acl;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','username','surname', 'email', 'password','api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function modules() {
        return $this->belongsToMany(Module::class,'user_module');
    }

    public function acls() {
        return $this->belongsToMany(Acl::class,'user_acl');
    }

    public function getModules($module = false) {

        $result = $this->modules()
            ->where('active',true);

        if($module) $result = $result->where('short_name',$module);

        return $result->get(array('short_name','permission','functions'));
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
            $userPermission = $userPermission[0]->attributes;
            ($userPermission['permission'] != 'ALL')? :$userPermission['permission'] = $userPermission['functions'];
            ($op != 'store')? :$op='create';
            ($op != 'update')? :$op='edit';

            return (strpos(" ".$userPermission['permission'],$op )>0 ? true : false);
        }
        return false;
    }

    public function getMyAcls() {
        return \Auth::user()->acls()->get()->pluck('id')->toArray();
    }

}

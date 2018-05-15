<?php

namespace App\Models;

use App\Models\Acl;
use App\Models\Device;
use App\Models\Module;
use App\Models\user_acl;
use App\Models\Profile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = array();
    //protected $fillable = ['*'];

    use SoftDeletes;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static $rules = array(
            'username'      => 'required|unique:users',
            'name'          => 'required',
            'surname'       => 'required',
            'password'      => 'required|between:8,16',
            'email'         => 'required|email|unique:users',
            'profile_id'    => 'required|integer',
        );

    public static $rules_change_pwd = array(
            'new_password'              =>'required|between:8,16',
            'new_password_confirmation' =>'required|same:new_password'
        );


    public function modules() {
        return $this->belongsToMany(Module::class)->withPivot('permission');
    }

    public function acls() {
        return $this->belongsToMany(Acl::class);
    }

    public function profile() {
        return $this->belongsTo(Profile::class);
    }

    public function devices() {
        return $this->belongsToMany(Device::class);
    }

    public function locations() {
        return $this->belongsToMany(Location::class);
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
        if($userPermission = $this->profile->getModules($module))
        {
            if($userPermission = $userPermission->first()) {
                $role = $userPermission->pivot->permission;
                ($role != 'ALL') ?: $role = $userPermission->functions;
                if (str_contains($op, '_')) {
                    list($op, $suf) = explode('_', $op, 2);
                    if (str_contains($op, 'store') || str_contains($op, 'update')) {
                        $op = $suf;
                    }
                } else {
                    (!str_contains($op, 'store')) ?: $op = 'create';
                    (!str_contains($op, 'update')) ?: $op = 'edit';
                }
                return (strpos(" " . $role, $op) > 0 ? true : false);
            }
        }
        return false;
    }

    public function getMyAcls($roots = false) {
        ($roots)? :$roots = $this->getMyForest();//dd($roots);
        $temp = array();
        foreach ($roots as $v ) {
            $temp[] = $v['id'];
            if (isset($v['branch']) && $v['branch'] != -1) {
                $temp = array_merge($temp, $this->getMyAcls($v['branch']));
            }
        }
        return array_unique($temp);
    }

    public function getMyTree($root) {
        $tree = array();
        if($branchs = Acl::where('parent_id',$root['id'])->get()->toArray()) {
            foreach ($branchs as $branch) {
                if ($branch['id'] != $root['id'])
                    $tree[] = array_add($branch, 'branch', $this->getMyTree($branch));
            }
        } else {
            $tree = -1;
        }
        return $tree ;
    }

    public function getMyForest() {
        $roots = $this->acls()->get()->toArray();
        $forest = array();
        foreach ($roots as $root) {
            $forest[] = array_add($root,'branch',$this->getMyTree($root));
        }
        $forest = $this->remove_element_by_value($forest,  -1);
        return $forest;
    }

    public function getMyRoot() {
        $forest = $this->getMyForest();
        $arRoot = array();
        foreach ($forest as $branch) {
            array_push($arRoot,$branch['id']);
        }
        return $arRoot;
    }

    protected function remove_element_by_value($arr, $val) {
        $return = array();
        foreach($arr as $k => $v) {
            if(is_array($v)) {
                $return[$k] = $this->remove_element_by_value($v, $val);
                continue;
            }
            if($v == $val) continue;
            $return[$k] = $v;
        }
        return $return;
    }


}

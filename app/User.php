<?php

namespace App;

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
        return $this->hasManyThrough('App\Models\Module','App\Models\users2module');
    }


    public function getModules() {
        return $this->modules()
                ->where('active',true)
                ->get(array('short_name'));
    }

    public function isAdmin() {

        return $this->modules()
                ->where('active',true)
                ->where('isadmin',true)
                ->get()->count();
    }
    


}

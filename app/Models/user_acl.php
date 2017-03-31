<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class user_acl extends Model
{
    protected $guarded = array();
    //protected $fillable = ['*'];

    protected $table = 'user_acl';

}

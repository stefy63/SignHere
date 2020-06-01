<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokenOtp extends Model
{
    protected $guarded = array();

    public static $rules = array(
            'token'      => 'required',
            'user_id'  => 'required|integer',
            'client_id'  => 'required|integer',
            'expired_time'  => 'date',
        );
    
    
    public function client() {
        return $this->hasOne(Client::class);
    }
    
    public function user() {
        return $this->hasOne(User::class);
    }
}

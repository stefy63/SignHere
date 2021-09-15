<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SignSession;

class SignDocument extends Model
{
    protected $guarded = array();

    public function sign_session() {
        $this->hasOne(SignSession::class);
    }
}

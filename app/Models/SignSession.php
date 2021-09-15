<?php

namespace App\Models;

use App\Models\SignDocument;
use Illuminate\Database\Eloquent\Model;

class SignSession extends Model
{
    protected $guarded = array();

    public function sign_documents() {
        $this->hasMany(SignDocument::class);
    }
}

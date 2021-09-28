<?php

namespace App\Models;

use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use App\Models\SignSession;

class SignDocument extends Model
{
    protected $guarded = array();

    public function sign_session() {
        $this->hasOne(SignSession::class);
    }

    public function document() {
        return $this->hasOne(Document::class, 'id', 'document_id');
    }
}

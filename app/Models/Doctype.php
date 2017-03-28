<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Document;

class Doctype extends Model
{
    protected $guarded = array();
    //protected $fillable = ['*'];


    public function documents() {
        return $this->hasMany(\App\Models\Document::class);
    }

}

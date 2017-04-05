<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Document;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctype extends Model
{
    protected $guarded = array();
    //protected $fillable = ['*'];

    use SoftDeletes;

    public static $rules = array(
        'name'      => 'required',
        'template'  => 'required',
    );

    public function documents() {
        return $this->hasMany(\App\Models\Document::class);
    }

}

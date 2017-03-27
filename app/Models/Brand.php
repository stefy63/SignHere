<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //protected $guarded = array();
    //protected $fillable = ['*'];

    public static $rules = array(
        'description'       => 'required',
        'vat'               => 'required|numeric',
        'address'           => 'required',
        'city'              => 'required',
        'region'            => 'required',
        'email'             => 'required|email',
    );

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model
{
    protected $guarded = array();
//    protected $fillable = ['*'];

    public static $rules = array(
            'name'      => 'required',
            'brand_id'  => 'required|integer',
            'template'  => 'required',
        );
    
    
    public function brand() {
        return $this->belongsTo(Brand::class);
    }
    
    public function user() {
        return $this->belongsTo(User::class);
    }
}

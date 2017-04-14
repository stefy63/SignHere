<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Acl;
use App\Models\Document;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    protected $guarded = array();
    //protected $fillable = ['*'];

    use SoftDeletes;

    public static $rules = array(
        'name'      => 'required',
        'email'     => 'required|email',
    );

    public function acls() {
        return $this->belongsToMany(Acl::class);
    }

    public function documents() {
        return $this->hasMany(Document::class);
    }
}

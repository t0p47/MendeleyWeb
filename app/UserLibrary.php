<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLibrary extends Model
{
    //
    protected $fillable = ['mid','reader_id','favorite'];
    public $timestamps = false;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    //
    protected $fillable = ['uid','type','mid','takescount'];

    public $timestamps = false;
}

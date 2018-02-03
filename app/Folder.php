<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    //
    protected $fillable = ['uid', 'name', 'parent_id','is_rename'];
    public $timestamps = false;

    
}

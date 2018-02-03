<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Laravel\Scout\Searchable;

class Journal extends Model
{
    //
	use Searchable;

    protected $fillable = ['title','uid','popularity'];

    public $timestamps = false;
}

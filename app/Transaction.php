<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	protected $fillable = ['amount','type','user_id','ip'];
	
	public function user()
    {
        return $this->belongsTo('App\User');
    }
}

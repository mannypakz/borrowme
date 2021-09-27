<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $fillable = [
    	'user_id',
    	'message',
    	'created_at',
    	'updated_at'
    ];

    public function user() {
  		return $this->belongsTo(User::class);
	}
}

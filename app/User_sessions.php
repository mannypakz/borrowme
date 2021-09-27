<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_sessions extends Model
{   
    protected $fillable = [
    	'user_id',
        'token',
        'redirected'
    ];
}
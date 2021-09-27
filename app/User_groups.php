<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_groups extends Model
{   
    protected $fillable = [
    	'user_id',
    	'group_user_id',
    	'accepted',
    	'first_name',
    	'last_name',
    	'image'
    ];
}
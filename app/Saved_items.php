<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Saved_items extends Model
{   
    protected $fillable = [
        'user_id',
        'product_id',
        'url',
        'name',
        'description',
        'vendor',
        'image'
    ];
}
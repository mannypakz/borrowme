<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{   
    protected $fillable = [
        'review_type',
        'user_id',
        'reference_id',
        'feedback',
        'stars'
    ];
}
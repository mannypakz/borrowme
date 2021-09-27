<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
    protected $fillable = [
        'menu_html',
        'menu_json',
        'created_at',
        'update_at',
    ];
}

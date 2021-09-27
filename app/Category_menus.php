<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category_menus extends Model
{   
    protected $fillable = [
        'menu_html',
        'menu_json'
    ];
}
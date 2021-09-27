<?php

namespace App\Services;

use App\Menu;

// use Illuminate\Support\Facades\DB;

class MenuService
{
    public function getAllMenus()
    {
        return Menu::all()->toArray();
    }
}

<?php

namespace App\Services;

use App\Categories;

// use Illuminate\Support\Facades\DB;

class CategoryService
{
    public function getAllCategories()
    {
        return Categories::all()->toArray();
    }
}

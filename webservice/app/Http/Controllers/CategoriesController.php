<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoriesController extends Controller
{
    public function all()
    {
        $categories = Category::all();
        return response()->json(compact('categories'), 200);
    }
}

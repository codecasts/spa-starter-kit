<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoriesController extends Controller
{
    public function all()
    {
        $pager = Category::paginate(10);
        return response()->json(compact('pager'), 200);
    }
}

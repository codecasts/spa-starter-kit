<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoriesController extends Controller
{
    public function all(Request $request)
    {
        $pager = Category::paginate(10);
        return response()->json(compact('pager'), 200);
    }

    public function remove($id)
    {
        $category = Category::find($id);
        $category->delete();
        return response()->json(['result' => 'success'], 200);
    }
}

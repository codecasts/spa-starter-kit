<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Http\Requests\CategoryRequest;

class CategoriesController extends Controller
{
    public function all(Request $request)
    {
        try {
            $pager = Category::paginate(10);
            return response()->json(compact('pager'), 200);
        } catch(\Exception $e) {
            return response()->json(['messages' => ['List of categories not available']], 404);
        }
    }

    public function get($id)
    {
        try {
            $category = Category::find($id);
            return response()->json(['result' => 'success', 'category' => $category], 200);
        } catch(\Exception $e) {
            return response()->json(['messages' => ['Category could not be fetched']], 404);
        }
    }

    public function create(CategoryRequest $request)
    {
        try {
            Category::create($request->only('name'));
            return response()->json(['result' => 'success'], 200);
        } catch(\Exception $e) {
            return response()->json(['messages' => ['Failed to create category']], 422);
        }
    }

    public function update($id, CategoryRequest $request)
    {
        try {
            $category = Category::find($id);
            $category->name = $request->get('name');
            $category->save();
            return response()->json(['result' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['messages' => ['Failed to update category']], 422);
        }
    }

    public function remove($id)
    {
        try {
            $category = Category::find($id);
            $category->delete();
            return response()->json(['result' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['messages' => ['Failed to remove category']], 422);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $pager = Category::paginate(10);

            return response()->json(compact('pager'), 200);
        } catch(\Exception $e) {
            return response()->json([
                'messages' => ['Failed to fetch categories'],
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        try {
            Category::create($request->only('name'));

            return response()->json([
                'result' => 'success',
            ], 200);
        } catch(\Exception $e) {
            return response()->json([
                'messages' => ['Failed to create category'],
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $category = Category::find($id);

            if (! $category) {
                return response()->json([
                    'messages' => ['Category not found'],
                ], 404);
            }

            return response()->json([
                'result' => 'success',
                'category' => $category,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'messages' => ['Failed to fetch category'],
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = Category::find($id);

            if (! $category) {
                return response()->json([
                    'messages' => ['Category not found'],
                ], 404);
            }

            $category->name = $request->get('name');
            $category->save();

            return response()->json([
                'result' => 'success',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'messages' => ['Failed to update category'],
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $category = Category::find($id);

            if (! $category) {
                return response()->json([
                    'messages' => ['Category not found'],
                ], 404);
            }
            
            $category->delete();

            return response()->json([
                'result' => 'success',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'messages' => ['Failed to remove category'],
            ], 500);
        }
    }
}

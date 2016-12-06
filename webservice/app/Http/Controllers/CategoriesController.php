<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use App\Transformers\CategoryTransformer;

class CategoriesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return $this->response(
                $this->transform->collection(Category::paginate(10), new CategoryTransformer)
            );
        } catch(\Exception $e) {
            return $this->responseWithInternalServerError('Failed to fetch categories');
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

            return $this->response(['result' => 'success']);
        } catch(\Exception $e) {
            return $this->responseWithInternalServerError('Failed to create category');
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
                return $this->responseWithNotFound('Category not found');
            }

            return $this->response(
                $this->transform->item($category, new CategoryTransformer)
            );
        } catch (\Exception $e) {
            return $this->responseWithInternalServerError('Failed to fetch category');
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
                return $this->responseWithNotFound('Category not found');
            }

            $category->name = $request->get('name');
            $category->save();

            return $this->response(['result' => 'success']);
        } catch (\Exception $e) {
            return $this->responseWithInternalServerError('Failed to update category');
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
                return $this->responseWithNotFound('Category not found');
            }
            
            $category->delete();

            return $this->response(['result' => 'success']);
        } catch (\Exception $e) {
            return $this->responseWithInternalServerError('Failed to remove category');
        }
    }
}

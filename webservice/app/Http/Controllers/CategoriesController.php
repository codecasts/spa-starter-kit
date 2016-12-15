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
        $sort = $this->getSort();
        $order = $this->getOrder();
        $limit = $this->getLimit();

        $categories = Category::orderBy($sort, $order)->paginate($limit);

        return $this->response(
            $this->transform->collection($categories, new CategoryTransformer)
        );
    }

    public function fullList()
    {
        return $this->response(
            $this->transform->collection(Category::all(), new CategoryTransformer)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        Category::create($request->only('name'));

        return $this->response(['result' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);

        if (! $category) {
            return $this->responseWithNotFound('Category not found');
        }

        return $this->response(
            $this->transform->item($category, new CategoryTransformer)
        );
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
        $category = Category::find($id);

        if (! $category) {
            return $this->responseWithNotFound('Category not found');
        }

        $category->name = $request->get('name');
        $category->save();

        return $this->response(['result' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if (! $category) {
            return $this->responseWithNotFound('Category not found');
        }

        $category->delete();

        return $this->response(['result' => 'success']);
    }
}

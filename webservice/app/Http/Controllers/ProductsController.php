<?php

namespace App\Http\Controllers;

use App\Product;
use App\Http\Requests\ProductRequest;

class ProductsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sort = $this->parameters->sort();
        $order = $this->parameters->order();
        $limit = $this->parameters->limit();

        $products = Product::orderBy($sort, $order)->paginate($limit);

        return $this->response->collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category,
        ]);

        return $this->response->withCreated($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (! $product) {
            return $this->response->withNotFound('Product not found');
        }

        return $this->response->item($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $product = Product::find($id);

        if (! $product) {
            return $this->response->withNotFound('Product not found');
        }

        $product->fill([
            'name' => $request->name,
            'category_id' => $request->category,
        ])->save();

        return $this->response->item($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (! $product) {
            return $this->response->withNotFound('Product not found');
        }

        $product->delete();

        return $this->response->withNoContent();
    }
}

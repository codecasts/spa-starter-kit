<?php

namespace App\Http\Controllers;

use App\Product;
use App\Http\Requests\ProductRequest;
use App\Transformers\ProductTransformer;

class ProductsController extends ApiController
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

        $products = Product::orderBy($sort, $order)->paginate($limit);

        return $this->response->collection($products, new ProductTransformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        Product::create([
            'name' => $request->name,
            'category_id' => $request->category,
        ]);

        return $this->response->json([
            'result' => 'success',
        ]);
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

        return $this->response->item($product, new ProductTransformer);
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

        $product->name = $request->name;
        $product->category_id = $request->category;

        $product->save();

        return $this->response->json([
            'result' => 'success',
        ]);
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

        return $this->response->json([
            'result' => 'success',
        ]);
    }
}

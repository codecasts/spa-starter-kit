<?php

namespace App\Transformers;

use App\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include.
     *
     * @var array
     */
    protected $availableIncludes = [
        'category',
    ];

    /**
     * List of default includes.
     *
     * @var array
     */
    protected $defaultIncludes = [
        'category',
    ];

    /**
     * Transform a product.
     *
     * @param  Product $product
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'created_at' => $product->created_at->toIso8601String(),
            'updated_at' => $product->updated_at->toIso8601String(),
        ];
    }

    /**
     * Include category.
     *
     * @param  Product $product
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeCategory(Product $product)
    {
        if ($product->category) {
            return $this->item($product->category, new CategoryTransformer);
        }
    }
}

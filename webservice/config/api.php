<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default transformers
    |--------------------------------------------------------------------------
    |
    | Here you may register default transformers, this transformers will be
    | used when you try to transform an eloquent model without specifying a
    | transformer, feel free to register as many as you need.
    |
    */

    'transformers' => [
        App\User::class => App\Transformers\UserTransformer::class,
        App\Product::class => App\Transformers\ProductTransformer::class,
        App\Category::class => App\Transformers\CategoryTransformer::class,
    ],
];

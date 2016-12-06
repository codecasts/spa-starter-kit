<?php

use App\Product;
use App\Category;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductsControllerTest extends ApiTestCase
{
    use DatabaseMigrations, WithoutMiddleware, Factory;

    /**
     * @test
     */
    public function can_list_products()
    {
        $category = $this->create(Category::class);

        $this->times(5)->create(Product::class, [
            'category_id' => $category->id,
        ]);

        $this->json('GET', '/api/products');

        $this->assertResponseOk();
        $this->seeJsonStructure([
            'data' => [
                '*' => ['name', 'category'],
            ],
            'meta' => ['pagination' => []],
        ]);
    }
}

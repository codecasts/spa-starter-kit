<?php

use App\Product;
use App\Category;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductsControllerTest extends ApiTestCase
{
    use DatabaseMigrations, WithoutMiddleware, Factory;

    /** @test */
    public function can_list_products()
    {
        $this->times(5)->create(Product::class, [
            'category_id' => $this->times(1)->create(Category::class)->id,
        ]);

        $this->json('GET', '/api/products');

        $this->assertResponseOk();
        $this->seeJsonStructure([
            'data' => ['*' => ['id', 'name', 'category']],
            'meta' => ['pagination' => []],
        ]);
    }

    /** @test */
    public function can_create_product()
    {
        $product = $this->fake->sentence;
        $category = $this->create(Category::class)->id;

        $this->json('POST', '/api/products', [
            'name' => $product,
            'category' => $category,
        ]);

        $this->assertResponseStatus(201);
        $this->seeJsonStructure(['data' => ['id', 'name', 'category']]);
        $this->seeJson(['name' => $product]);
        $this->seeInDatabase('products', ['name' => $product, 'category_id' => $category]);
    }

    /** @test */
    public function can_show_product()
    {
        $product = $this->create(Product::class, [
            'category_id' => $this->create(Category::class)->id,
        ]);

        $this->json('GET', '/api/products/1');

        $this->assertResponseOk();
        $this->seeJsonStructure(['data' => ['id', 'name', 'category']]);
        $this->seeJson(['name' => $product->name]);
    }

    /** @test */
    public function can_update_product()
    {
        $this->create(Product::class, [
            'category_id' => $this->create(Category::class)->id,
        ]);

        $category = $this->create(Category::class)->id;

        $this->json('PUT', '/api/products/1', [
            'name' => 'new product name',
            'category' => $category,
        ]);

        $this->assertResponseStatus(200);
        $this->seeInDatabase('products', [
            'name' => 'new product name',
            'category_id' => $category,
        ]);
        $this->seeJson(['id' => 1]);
        $this->seeJsonStructure([
            'data' => ['id', 'name', 'category'],
        ]);
    }

    /** @test */
    public function can_delete_product()
    {
        $this->create(Product::class, [
            'category_id' => $this->create(Category::class)->id,
        ]);

        $this->json('DELETE', '/api/products/1');

        $this->assertResponseStatus(204);
        $this->dontSeeInDatabase('products', ['id' => 1]);
    }

    /**
     * @test
     * @dataProvider requestUrlProvider
     */
    public function get_404_when_product_dont_exist($method, $url, $data = [])
    {
        $this->create(Category::class);

        $this->json($method, $url, $data);

        $this->assertResponseStatus(404);
        $this->seeJsonStructure(['messages' => []]);
    }

    /**
     * Request Url provider.
     *
     * @return array
     */
    public function requestUrlProvider()
    {
        return [
            ['GET', '/api/products/1'],
            ['PUT', '/api/products/1', ['name' => 'update', 'category' => 1]],
            ['DELETE', '/api/products/1'],
        ];
    }
}

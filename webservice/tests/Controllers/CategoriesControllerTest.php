<?php

use App\Category;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoriesControllerTest extends ApiTestCase
{
    use DatabaseMigrations, WithoutMiddleware, Factory;

    /** @test */
    public function can_list_categories()
    {
        $this->times(5)->create(Category::class);

        $this->json('GET', '/api/categories');

        $this->assertResponseOk();
        $this->seeJsonStructure([
            'data' => ['*' => ['id', 'name']],
            'meta' => ['pagination' => []],
        ]);
    }

    /** @test */
    public function can_create_category()
    {
        $category = $this->make(Category::class);

        $this->json('POST', '/api/categories', [
            'name' => $category->name,
        ]);

        $this->assertResponseStatus(201);
        $this->seeJsonStructure(['data' => ['id', 'name']]);
        $this->seeJson(['name' => $category->name]);
        $this->seeInDatabase('categories', ['name' => $category->name]);
    }

    /** @test */
    public function can_show_category()
    {
        $category = $this->create(Category::class);

        $this->json('GET', '/api/categories/1');

        $this->assertResponseOk();
        $this->seeJsonStructure(['data' => ['id', 'name']]);
        $this->seeJson(['name' => $category->name]);
    }

    /** @test */
    public function can_update_category()
    {
        $this->create(Category::class);

        $this->json('PUT', '/api/categories/1', [
            'name' => 'new category name',
        ]);

        $this->assertResponseStatus(200);
        $this->seeInDatabase('categories', ['name' => 'new category name']);
        $this->seeJson(['id' => 1]);
        $this->seeJsonStructure([
            'data' => ['id', 'name'],
        ]);
    }

    /** @test */
    public function can_delete_category()
    {
        $this->create(Category::class);

        $this->json('DELETE', '/api/categories/1');

        $this->assertResponseStatus(204);
        $this->dontSeeInDatabase('categories', ['id' => 1]);
    }

    /**
     * @test
     * @dataProvider requestUrlProvider
     */
    public function get_404_when_category_dont_exist($method, $url, $data = [])
    {
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
            ['GET', '/api/categories/1'],
            ['PUT', '/api/categories/1', ['name' => 'update']],
            ['DELETE', '/api/categories/1'],
        ];
    }
}

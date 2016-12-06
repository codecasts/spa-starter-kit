<?php

use App\Category;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoriesControllerTest extends ApiTestCase
{
    use DatabaseMigrations, WithoutMiddleware, Factory;

    /**
     * @test
     */
    public function can_delete_category()
    {
        $this->create(Category::class);

        $this->json('DELETE', '/api/categories/1');

        $this->assertResponseOk();
        $this->dontSeeInDatabase('categories', ['id' => 1]);
    }

    /**
     * @test
     */
    public function can_update_category()
    {
        $this->create(Category::class);

        $this->json('PUT', '/api/categories/1', [
            'name' => 'Dummy',
        ]);

        $this->assertResponseOk();
        $this->seeInDatabase('categories', [
            'id' => 1,
            'name' => 'Dummy',
        ]);
    }

    /**
     * @test
     * @dataProvider urlProvider
     */
    public function get_not_found_if_category_dont_exist($method, $url)
    {
        $this->json($method, $url, [
            'name' => 'Dummy',
        ]);

        $this->assertResponseStatus(404);
        $this->seeJsonStructure([
            'messages' => [[]],
        ]);
    }

    /**
     * Url data privider.
     *
     * @return array
     */
    public function urlProvider()
    {
        return [
            ['GET', '/api/categories/1'],
            ['PUT', '/api/categories/1'],
            ['DELETE', '/api/categories/1'],
        ];
    }

    /**
     * @test
     */
    public function can_get_category()
    {
        $this->create(Category::class, [
            'name' => 'Dummy',
        ]);

        $this->json('GET', '/api/categories/1');

        $this->assertResponseOk();
        
        $this->seeJsonStructure([
            'data' => [
                'id', 'name',   
            ],
        ]); 
        
        $this->seeJson([
            'name' => 'Dummy',
        ]);
    }

    /**
     * @test
     */
    public function can_create_category()
    {
        $this->json('POST', '/api/categories', [
            'name' => 'Dummy name',
        ]);

        $this->assertResponseOk();
        $this->seeInDatabase('categories', [
            'name' => 'Dummy name',
        ]);
    }

    /**
     * @test
     */
    public function can_get_categories()
    {
        $this->times(3)->create(Category::class);

        $this->json('GET', '/api/categories');

        $this->assertResponseOk();
        $this->seeJsonStructure([
            'data' => [
                '*' => ['id', 'name'],
            ],
            'meta' => [
                'pagination' => [],
            ],
        ]);
    }
}

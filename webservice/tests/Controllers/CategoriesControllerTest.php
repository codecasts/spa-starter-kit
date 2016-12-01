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
     * @dataProvider urlProvider
     */
    public function get_not_found_if_category_dont_exist($url)
    {
        $this->json('GET', $url);

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
            ['/api/categories/1/get'],
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

        $this->json('GET', '/api/categories/1/get');

        $this->assertResponseOk();
        
        $this->seeJsonStructure([
            'result', 'category' => [
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
        $this->json('POST', '/api/categories/create', [
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
            'pager' => [
                'data' => [
                    '*' => ['id', 'name'],
                ],
            ],
        ]);
    }
}

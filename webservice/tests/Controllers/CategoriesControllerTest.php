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

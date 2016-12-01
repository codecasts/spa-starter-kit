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
    public function it_can_list_registered_categories()
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

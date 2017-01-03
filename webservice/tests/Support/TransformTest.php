<?php

use App\Support\Transform;
use League\Fractal\Manager;
use League\Fractal\TransformerAbstract;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TransformTest extends TestCase
{
    /** @test */
    public function can_transform_collection_with_pagination()
    {
        $data = Mockery::mock(LengthAwarePaginator::class, function ($mock) {
            $mock->shouldReceive('currentPage', 'lastPage', 'total', 'count', 'perPage');
        });

        $transform = $this->getTransformInstance();
        $transformer = $this->getTransformerMock(['data']);

        $this->assertEquals([
            'data' => [],
            'meta' => [
                'pagination' => [
                    'total' => 0,
                    'per_page' => 0,
                    'current_page' => 0,
                    'links' => [],
                    'count' => 0,
                    'total_pages' => 0,
                ],
            ],
        ], $transform->collection($data, $transformer));
    }

    /** @test */
    public function can_transform_collection()
    {
        $data = [
            ['some data'], ['some data'], ['some data'],
        ];

        $transform = $this->getTransformInstance();
        $transformer = $this->getTransformerMock(['data']);

        return $this->assertEquals([
            'data' => [
                ['data'], ['data'], ['data']
            ],
        ], $transform->collection($data, $transformer));
    }

    /** @test */
    public function can_transform_item()
    {
        $transform = $this->getTransformInstance();
        $transformer = $this->getTransformerMock(['transformed data']);

        return $this->assertEquals([
            'data' => ['transformed data'],
        ], $transform->item(['some data'], $transformer));
    }

    /**
     * Get a transformer mock.
     *
     * @param  array  $transformedData
     *
     * @return \League\Fractal\TransformerAbstract
     */
    private function getTransformerMock($transformedData = [])
    {
        return Mockery::mock(TransformerAbstract::class, function ($mock) use ($transformedData) {
            $mock->shouldReceive('setCurrentScope', 'getDefaultIncludes', 'getAvailableIncludes');
            $mock->shouldReceive('transform')->andReturn($transformedData);
        });
    }

    /**
     * Get a fresh instance of the Transform class.
     *
     * @return \App\Support\Transform
     */
    private function getTransformInstance()
    {
        return resolve(Transform::class);
    }
}

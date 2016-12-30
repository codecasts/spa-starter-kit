<?php

use Illuminate\Http\JsonResponse;
use App\Support\Response;
use App\Support\Transform;
use League\Fractal\TransformerAbstract;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ResponseTest extends TestCase
{
    /**
     * Get a fresh instance of the Response class.
     *
     * @param  ResponseFactory|null $factory
     * @param  Transform|null       $transform
     *
     * @return Response
     */
    private function getResponseInstance(ResponseFactory $factory = null, Transform $transform = null)
    {
        return new Response(
            $factory ?: resolve(ResponseFactory::class),
            $transform ?: resolve(Transform::class)
        );
    }

    /** @test */
    public function can_set_status_code()
    {
        $response = $this->getResponseInstance();

        $this->assertEquals(999, $response->setStatusCode(999)->getStatusCode());
    }

    /** @test */
    public function can_make_json_response()
    {
        $response = $this->getResponseInstance()->json();

        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    /** @test */
    public function can_make_an_error_response()
    {
        $response = $this->getResponseInstance()->withError('message');

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals([
            'messages' => ['message'],
        ], $response->getData(true));
    }

    /** @test */
    public function can_make_no_content_error_response()
    {
        $response = $this->getResponseInstance()->withNoContent();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals([], $response->getData(true));
        $this->assertEquals(204, $response->status());
    }

    /** @test */
    public function can_make_not_found_error_response()
    {
        $response = $this->getResponseInstance()->withNotFound();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(['messages' => ['Not Found']], $response->getData(true));
        $this->assertEquals(404, $response->status());
    }

    /** @test */
    public function can_make_internal_server_error_response()
    {
        $response = $this->getResponseInstance()->withInternalServerError();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(['messages' => ['Internal Server Error']], $response->getData(true));
        $this->assertEquals(500, $response->status());
    }

    /** @test */
    public function can_make_unauthorized_error_response()
    {
        $response = $this->getResponseInstance()->withUnauthorized();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(['messages' => ['Unauthorized']], $response->getData(true));
        $this->assertEquals(401, $response->status());
    }

    /** @test */
    public function can_make_too_many_requests_error_response()
    {
        $response = $this->getResponseInstance()->withTooManyRequests();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(['messages' => ['Too Many Requests']], $response->getData(true));
        $this->assertEquals(429, $response->status());
    }

    /** @test */
    public function can_make_created_response()
    {
        $response = $this->getResponseInstance()->withCreated();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals([], $response->getData(true));
        $this->assertEquals(201, $response->status());
    }

    /** @test */
    public function can_transform_a_collection_of_items()
    {
        $data = ['Dummy transformed data'];

        $transform = Mockery::mock(Transform::class, function ($transform) use ($data) {
            $transform->shouldReceive('collection')->andReturn($data);
        });

        $transformer = $this->getMockForAbstractClass(TransformerAbstract::class);

        $response = $this->getResponseInstance(null, $transform)->collection(['Dummy data'], $transformer);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($data, $response->getData(true));
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function can_transform_a_single_item()
    {
        $data = ['Dummy transformed data'];

        $transform = Mockery::mock(Transform::class, function ($transform) use ($data) {
            $transform->shouldReceive('item')->andReturn($data);
        });

        $transformer = $this->getMockForAbstractClass(TransformerAbstract::class);

        $response = $this->getResponseInstance(null, $transform)->item(['Dummy data'], $transformer);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($data, $response->getData(true));
        $this->assertEquals(200, $response->status());
    }
}

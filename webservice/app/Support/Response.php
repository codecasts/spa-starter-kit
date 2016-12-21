<?php

namespace App\Support;

use App\Transformers\Transform;
use League\Fractal\TransformerAbstract;
use Illuminate\Contracts\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class Response
{
    /**
     * HTTP Response.
     *
     * @var \Illuminate\Contracts\Routing\ResponseFactory
     */
    private $response;

    /**
     * API transformer helper.
     *
     * @var \App\Transformers\Transform
     */
    public $transform;

    /**
     * HTTP status code.
     *
     * @var int
     */
    private $statusCode = HttpResponse::HTTP_OK;

    /**
     * Create a new class instance.
     *
     * @param ResponseFactory $response
     * @param Transform       $transform
     */
    public function __construct(ResponseFactory $response, Transform $transform)
    {
        $this->response = $response;
        $this->transform = $transform;
    }

    /**
     * Return a 429 response.
     *
     * @param  string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withTooManyRequests($message = 'Too Many Requests')
    {
        return $this->setStatusCode(
            HttpResponse::HTTP_TOO_MANY_REQUESTS
        )->withError($message);
    }

    /**
     * Return a 401 response.
     *
     * @param  string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withUnauthorized($message = 'Unauthorized')
    {
        return $this->setStatusCode(
            HttpResponse::HTTP_UNAUTHORIZED
        )->withError($message);
    }

    /**
     * Return a 500 response.
     *
     * @param  string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withInternalServerError($message = 'Internal Server Error')
    {
        return $this->setStatusCode(
            HttpResponse::HTTP_INTERNAL_SERVER_ERROR
        )->withError($message);
    }

    /**
     * Return a 404 response.
     *
     * @param  string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withNotFound($message = 'Not Found')
    {
        return $this->setStatusCode(
            HttpResponse::HTTP_NOT_FOUND
        )->withError($message);
    }

    /**
     * Make an error response.
     *
     * @param  mixed $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withError($message)
    {
        return $this->with([
            'messages' => (is_array($message) ? $message : [$message]),
        ]);
    }

    /**
     * Make a 204 response.
     *
     * @param  string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withNoContent()
    {
        return $this->setStatusCode(
            HttpResponse::HTTP_NO_CONTENT
        )->with();
    }

    /**
     * Make a JSON response with the transformed item.
     *
     * @param  mixed               $item
     * @param  TransformerAbstract $transformer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function item($item, TransformerAbstract $transformer)
    {
        return $this->with(
            $this->transform->item($item, $transformer)
        );
    }

    /**
     * Make a JSON response with the transformed items.
     *
     * @param  mixed               $items
     * @param  TransformerAbstract $transformer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function collection($items, TransformerAbstract $transformer)
    {
        return $this->with(
            $this->transform->collection($items, $transformer)
        );
    }

    /**
     * Make a JSON response.
     *
     * @param  mixed  $data
     * @param  array  $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function with($data = [], array $headers = [])
    {
        return $this->response->json($data, $this->statusCode, $headers);
    }

    /**
     * Set HTTP status code.
     *
     * @param int $statusCode
     *
     * @return self
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Gets the HTTP status code.
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
}

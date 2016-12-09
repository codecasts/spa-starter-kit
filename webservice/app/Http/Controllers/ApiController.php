<?php

namespace App\Http\Controllers;

use App\Transformers\Transform;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Routing\ResponseFactory;

abstract class ApiController extends Controller
{
    /**
     * HTTP Response.
     *
     * @var \Illuminate\Contracts\Routing\ResponseFactory
     */
    private $response;

    /**
     * HTTP status code.
     *
     * @var int
     */
    private $statusCode = Response::HTTP_OK;

    /**
     * Transform.
     *
     * @var \App\Transformers\Transform
     */
    protected $transform;

    /**
     * Creates a new class instance.
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
     * @return \Illuminate\Http\Response
     */
    protected function responseWithTooManyRequests($message = 'Too Many Requests')
    {
        return $this->setStatusCode(Response::HTTP_TOO_MANY_REQUESTS)->responseWithError($message);
    }

    /**
     * Return a 401 response.
     *
     * @param  string $message
     *
     * @return \Illuminate\Http\Response
     */
    protected function responseWithUnauthorized($message = 'Unauthorized')
    {
        return $this->setStatusCode(Response::HTTP_UNAUTHORIZED)->responseWithError($message);    
    }

    /**
     * Return a 500 response.
     *
     * @param  string $message
     *
     * @return \Illuminate\Http\Response
     */
    protected function responseWithInternalServerError($message = 'Internal Server Error')
    {
        return $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)->responseWithError($message);
    }

    /**
     * Return a 404 response.
     *
     * @param  string $message
     *
     * @return \Illuminate\Http\Response
     */
    protected function responseWithNotFound($message = 'Not Found')
    {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)->responseWithError($message);
    }

    /**
     * Return an error response.
     *
     * @param  mixed $message
     *
     * @return \Illuminate\Http\Response
     */
    protected function responseWithError($message)
    {
        return $this->response([
            'messages' => (is_array($message) ? $message : [$message]),
        ]);
    }

    /**
     * Return a 204 response.
     *
     * @param  string $message
     *
     * @return \Illuminate\Http\Response
     */
    protected function responseWithNoContent()
    {
        return $this->setStatusCode(Response::HTTP_NO_CONTENT)
            ->response([]);
    }

    /**
     * Return a JSON response.
     *
     * @param  mixed  $data
     * @param  array  $headers
     *
     * @return \Illuminate\Http\Response
     */
    protected function response($data, array $headers = [])
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
    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }
}
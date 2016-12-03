<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Contracts\Routing\ResponseFactory;

abstract class ApiController extends Controller
{
    /**
     * HTTP Response.
     *
     * @var \Illuminate\Contracts\Routing\ResponseFactory
     */
    protected $response;

    /**
     * HTTP status code.
     *
     * @var int
     */
    protected $statusCode = 200;


    /**
     * Creates a new class instance.
     *
     * @param \Illuminate\Contracts\Routing\ResponseFactory $response
     */
    public function __construct(ResponseFactory $response)
    {
        $this->response = $response;
    }

    /**
     * Return a 500 response.
     *
     * @param  string $message
     *
     * @return \Illuminate\Http\Response
     */
    protected function responseWithInternalServerError($message = 'Internal server error')
    {
        return $this->setStatusCode(500)->responseWithError($message);
    }

    /**
     * Return a 404 response.
     *
     * @param  string $message
     *
     * @return \Illuminate\Http\Response
     */
    protected function responseWithNotFound($message = 'Not found')
    {
        return $this->setStatusCode(404)->responseWithError($message);
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
<?php

namespace App\Support;

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
     * HTTP status code.
     *
     * @var int
     */
    private $statusCode = HttpResponse::HTTP_OK;

    /**
     * Create a new class instance.
     */
    public function __construct(ResponseFactory $response)
    {
        $this->response = $response;
    }


    /**
     * Return a 429 response.
     *
     * @param  string $message
     *
     * @return \Illuminate\Http\Response
     */
    public function withTooManyRequests($message = 'Too Many Requests')
    {
        return $this->status(HttpResponse::HTTP_TOO_MANY_REQUESTS)->withError($message);
    }

    /**
     * Return a 401 response.
     *
     * @param  string $message
     *
     * @return \Illuminate\Http\Response
     */
    public function withUnauthorized($message = 'Unauthorized')
    {
        return $this->status(HttpResponse::HTTP_UNAUTHORIZED)->withError($message);
    }

    /**
     * Return a 500 response.
     *
     * @param  string $message
     *
     * @return \Illuminate\Http\Response
     */
    public function withInternalServerError($message = 'Internal Server Error')
    {
        return $this->status(HttpResponse::HTTP_INTERNAL_SERVER_ERROR)->withError($message);
    }

    /**
     * Return a 404 response.
     *
     * @param  string $message
     *
     * @return \Illuminate\Http\Response
     */
    public function withNotFound($message = 'Not Found')
    {
        return $this->status(HttpResponse::HTTP_NOT_FOUND)->withError($message);
    }

    /**
     * Make an error response.
     *
     * @param  mixed $message
     *
     * @return \Illuminate\Http\Response
     */
    public function withError($message)
    {
        return $this->make([
            'messages' => (is_array($message) ? $message : [$message]),
        ]);
    }

    /**
     * Make a 204 response.
     *
     * @param  string $message
     *
     * @return \Illuminate\Http\Response
     */
    public function withNoContent()
    {
        return $this->status(HttpResponse::HTTP_NO_CONTENT)
            ->make([]);
    }

    /**
     * Make a JSON response.
     *
     * @param  mixed  $data
     * @param  array  $headers
     *
     * @return \Illuminate\Http\Response
     */
    public function make($data, array $headers = [])
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
    public function status($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }
}

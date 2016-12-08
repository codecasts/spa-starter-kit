<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exception\HttpResponseException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($request->expectsJson()) {
            return $this->handleExceptionJsonResponse($request, $exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * Handle the JSON response for all the exceptions.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $e
     *
     * @return \Illuminate\Http\Response
     */
    protected function handleExceptionJsonResponse($request, Exception $e)
    {
        // If it's an authentication exception then return a JSON response with status code of 401
        if ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        }

        // If it's a validation exception then return a JSON response with status code of 422
        if ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }

        $code = 500;
        $body = [
            'messages' => [$e->getMessage()],
        ];

        // If it's a HttpException then use the appropriate HTTP status code instead of 500
        if ($e instanceof HttpException) {
            $code = $e->getStatusCode();
        }

        // If the debugging is on then include the exception trace in the body of the response
        if (config('app.debug')) {
            $body['trace'] = $e->getTrace();
        }

        return response()->json($body, $code);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => ['Unauthenticated.']], 401);
        }

        return redirect()->guest('login');
    }
}

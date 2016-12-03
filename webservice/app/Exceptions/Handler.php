<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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

            if ($exception instanceof UnauthorizedHttpException) {
                return $this->handleUnauthorizedHttpException($exception);
            }

            if ($exception instanceof HttpException) {
                return $this->handleExceptionJsonResponse($exception);
            }
        }

        return parent::render($request, $exception);
    }

    /**
     * Handle the JSON response for the HTTP exceptions.
     *
     * @param  \Exception $exception
     *
     * @return \Illuminate\Http\Response
     */
    protected function handleExceptionJsonResponse(Exception $exception)
    {
        return response()->json([
            'messages' => [$exception->getMessage()],
        ], $exception->getStatusCode());
    }

    /**
     * Handle the JSON response for the UnauthorizedHttpException.
     *
     * @param UnauthorizedHttpException $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function handleUnauthorizedHttpException(UnauthorizedHttpException $exception)
    {
        $headers = $exception->getHeaders();

        if (isset($headers['WWW-Authenticate']) && $headers['WWW-Authenticate'] == 'jwt-auth') {

            $message = $exception->getMessage();

            if(false === !strpos($message, 'expired')) {
                return response()->json([
                    'reason' => 'token_expired',
                    'messages' => [$exception->getMessage()]
                ], $exception->getStatusCode());
            }
        }

        return $this->handleExceptionJsonResponse($exception);
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

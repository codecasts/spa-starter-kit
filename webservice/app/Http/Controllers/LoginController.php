<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use Lang;

class LoginController extends Controller
{
    use ThrottlesLogins;

    public function login(Request $request)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $request->only('email', 'password');

        if ($token = Auth::guard('api')->attempt($credentials)) {
            return $this->sendLoginResponse($request, $token);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function sendLoginResponse(Request $request, $token)
    {
        $this->clearLoginAttempts($request);

        $user = Auth::guard('api')->user();

        return response()->json(compact('token', 'user'));
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $message = Lang::get('auth.failed');

        return response()->json(['messages' => [$message]], 401);
    }

    public function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        $message = Lang::get('auth.throttle', ['seconds' => $seconds]);

        return response()->json(['messages' => [$message]], Response::HTTP_TOO_MANY_REQUESTS);
    }

    public function username()
    {
        return 'email';
    }
}

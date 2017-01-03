<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class MeController extends ApiController
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::guard('api')->user();

        return $this->response->item($user);
    }
}

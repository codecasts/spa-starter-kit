<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Transformers\UserTransformer;

class MeController extends ApiController
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return $this->response(
            $this->transform->item(Auth::guard('api')->user(), new UserTransformer)
        );
    }
}

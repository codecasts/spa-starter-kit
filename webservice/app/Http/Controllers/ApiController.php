<?php

namespace App\Http\Controllers;

use App\Traits\Response;
use App\Transformers\Transform;
use Illuminate\Contracts\Routing\ResponseFactory;

abstract class ApiController extends Controller
{
    use Response;

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
}

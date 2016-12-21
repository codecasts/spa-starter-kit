<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\QueryParameters;
use App\Transformers\Transform;
use Illuminate\Contracts\Routing\ResponseFactory;

abstract class ApiController extends Controller
{
    use QueryParameters;

    /**
     * Transform.
     *
     * @var \App\Transformers\Transform
     */
    protected $transform;

    /**
     * Creates a new class instance.
     *
     * @param Request         $request
     * @param ResponseFactory $response
     * @param Transform       $transform
     */
    public function __construct(Request $request, ResponseFactory $response, Transform $transform)
    {
        $this->request = $request;
        $this->response = $response;
        $this->transform = $transform;
    }
}

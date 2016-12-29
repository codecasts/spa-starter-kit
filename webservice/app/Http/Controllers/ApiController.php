<?php

namespace App\Http\Controllers;

use App\Support\Response;
use App\Support\Parameters;

abstract class ApiController extends Controller
{
    /**
     * API response helper.
     *
     * @var \App\Support\Response
     */
    protected $response;

    /**
     * API parameters helper.
     *
     * @var \App\Support\Parameters
     */
    protected $parameters;

    /**
     * Creates a new class instance.
     *
     * @param Response   $response
     * @param Parameters $parameters
     */
    public function __construct(Response $response, Parameters $parameters)
    {
        $this->response = $response;
        $this->parameters = $parameters;
    }
}

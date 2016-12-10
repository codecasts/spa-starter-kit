<?php

namespace App\Traits;

trait QueryParameters
{
    /**
     * HTTP Request.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * Get order parameter.
     *
     * @param  string $default
     *
     * @return string
     */
    protected function getOrder($default = 'desc')
    {
        return $this->getParameter('order', $default);
    }

    /**
     * Get sort parameter.
     *
     * @param  string $default
     *
     * @return string
     */
    protected function getSort($default = 'id')
    {
        return $this->getParameter('sort', $default);
    }

    /**
     * Get limit parameter.
     *
     * @param  int $default
     *
     * @return int
     */
    protected function getLimit($default = 10)
    {
        return $this->getParameter('limit', $default);
    }

    /**
     * Get query parameter by name.
     *
     * @param  string $name
     * @param  mixed  $default
     *
     * @return mixed
     */
    protected function getParameter($name, $default = null)
    {
        return $this->request->query($name, $default);
    }
}

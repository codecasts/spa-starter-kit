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
     * @param  string $order
     *
     * @return string
     */
    protected function getOrder($order = 'desc')
    {
        return $this->getParameter('order', $order);
    }

    /**
     * Get sort parameter.
     *
     * @param  string $column
     *
     * @return string
     */
    protected function getSort($column = 'id')
    {
        return $this->getParameter('sort', $column);
    }

    /**
     * Get limit parameter.
     *
     * @param  int $limit
     *
     * @return int
     */
    protected function getLimit($limit = 10)
    {
        return $this->getParameter('limit', $limit);
    }

    /**
     * Retrive a query parameter from the request.
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

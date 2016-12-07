<?php

trait Factory
{
    /**
     * Number of times to run.
     *
     * @var int
     */
    private $times = 1;

    /**
     * Create resource data.
     *
     * @param  string $resource
     * @param  array  $data
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    protected function create($resource, array $data = [])
    {
        if ($this->times > 1) {
            return factory($resource, $this->times)->create($data);
        }

        return factory($resource)->create($data);
    }

    /**
     * Make resource data.
     *
     * @param  string $resource
     * @param  array  $data
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    protected function make($resource, array $data = [])
    {
        if ($this->times > 1) {
            return factory($resource, $this->times)->make($data);
        }

        return factory($resource)->make($data);
    }

    /**
     * Set the number of times to run.
     *
     * @param  int $times
     *
     * @return self
     */
    protected function times($times)
    {
        $this->times = $times;

        return $this;
    }
}

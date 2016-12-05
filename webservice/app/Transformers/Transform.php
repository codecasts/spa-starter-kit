<?php

namespace App\Transformers;

use League\Fractal\Manager;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection as FractalCollection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class Transform
{
    /**
     * Fractal manager.
     *
     * @var \League\Fractal\Manager
     */
    private $fractal;

    /**
     * Create a new class instance.
     */
    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    /**
     * Transform a collection of data.
     *
     * @param  EloquentCollection  $data
     * @param  TransformerAbstract $transformer
     *
     * @return array
     */
    public function collection(EloquentCollection $data, TransformerAbstract $transformer)
    {
        return $this->fractal->createData(
            new FractalCollection($data, $transformer)
        )->toArray();
    }
}
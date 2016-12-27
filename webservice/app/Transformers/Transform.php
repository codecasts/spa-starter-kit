<?php

namespace App\Transformers;

use League\Fractal\Manager;
use League\Fractal\TransformerAbstract;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Item as FractalItem;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection as FractalCollection;

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
     * @param  mixed               $data
     * @param  TransformerAbstract $transformer
     *
     * @return array
     */
    public function collection($data, TransformerAbstract $transformer)
    {
        $collection = new FractalCollection($data, $transformer);

        if ($data instanceof LengthAwarePaginator) {
            $collection->setPaginator(new IlluminatePaginatorAdapter($data));
        }

        return $this->fractal->createData($collection)->toArray();
    }

    /**
     * Transform a single data.
     *
     * @param  mixed               $data
     * @param  TransformerAbstract $transformer
     *
     * @return array
     */
    public function item($data, TransformerAbstract $transformer)
    {
        return $this->fractal->createData(
            new FractalItem($data, $transformer)
        )->toArray();
    }
}

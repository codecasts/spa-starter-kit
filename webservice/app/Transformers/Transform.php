<?php

namespace App\Transformers;

use League\Fractal\Manager;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Item as FractalItem;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
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
     * @param  EloquentCollection|LengthAwarePaginator $data
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
     * @param  Model               $data
     * @param  TransformerAbstract $transformer
     *
     * @return array
     */
    public function item(Model $data, TransformerAbstract $transformer)
    {
        return $this->fractal->createData(
            new FractalItem($data, $transformer)
        )->toArray();
    }
}

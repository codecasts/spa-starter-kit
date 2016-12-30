<?php

namespace App\Support;

use League\Fractal\Manager;
use League\Fractal\TransformerAbstract;
use Illuminate\Database\Eloquent\Collection;
use League\Fractal\Resource\Item as FractalItem;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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
     * @param  mixed                    $data
     * @param  TransformerAbstract|null $transformer
     *
     * @return array
     */
    public function collection($data, TransformerAbstract $transformer = null)
    {
        $transformer = $transformer ?: $this->fetchDefaultTransformer($data);
        $collection = new FractalCollection($data, $transformer);

        if ($data instanceof LengthAwarePaginator) {
            $collection->setPaginator(new IlluminatePaginatorAdapter($data));
        }

        return $this->fractal->createData($collection)->toArray();
    }

    /**
     * Transform a single data.
     *
     * @param  mixed                    $data
     * @param  TransformerAbstract|null $transformer
     *
     * @return array
     */
    public function item($data, TransformerAbstract $transformer = null)
    {
        $transformer = $transformer ?: $this->fetchDefaultTransformer($data);

        return $this->fractal->createData(
            new FractalItem($data, $transformer)
        )->toArray();
    }

    /**
     * Tries to fetch a default transformer for the given data.
     *
     * @param  mixed $data
     *
     * @return \League\Fractal\TransformerAbstract|null
     */
    protected function fetchDefaultTransformer($data)
    {
        $classname = $this->getClassnameFrom($data);

        if ($this->hasDefaultTransformer($classname)) {
            $transformer = config('api.transformers.'.$classname);

            return new $transformer;
        }
    }

    /**
     * Check if the class has a default transformer.
     *
     * @param  string $classname
     *
     * @return bool
     */
    protected function hasDefaultTransformer($classname)
    {
        return ! is_null(config('api.transformers.'.$classname));
    }

    /**
     * Get the class name from the given object.
     *
     * @param  object $object
     *
     * @return string
     */
    protected function getClassnameFrom($object)
    {
        if ($object instanceof LengthAwarePaginator or $object instanceof Collection) {
            return get_class(array_first($object));
        }

        return get_class($object);
    }
}

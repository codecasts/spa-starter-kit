<?php

namespace App\Providers;

use League\Fractal\Manager;
use App\Transformers\Transform;
use Illuminate\Support\ServiceProvider;
use League\Fractal\Serializer\DataArraySerializer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Transform::class, function () {
            $fractal = new Manager;

            if (request()->has('include')) {
                $fractal->parseIncludes(request()->query('include'));
            }

            $fractal->setSerializer(new DataArraySerializer);

            return new Transform($fractal);
        });
    }
}

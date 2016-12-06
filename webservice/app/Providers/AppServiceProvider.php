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
            return new Transform(
                (new Manager)->setSerializer(new DataArraySerializer)
            );
        });
    }
}

<?php

namespace App\Providers;

use App\Support\Transform;
use League\Fractal\Manager;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(Transform::class, function ($app) {
            $fractal = new Manager;
            $serializer = $app['config']->get('api.serializer');

            if (request()->has('include')) {
                $fractal->parseIncludes(request()->query('include'));
            }

            $fractal->setSerializer(new $serializer);

            return new Transform($fractal);
        });
    }
}

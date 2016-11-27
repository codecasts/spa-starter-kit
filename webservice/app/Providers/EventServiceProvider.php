<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Event::listen('tymon.jwt.absent', function () {
            return response()->json(
                ['reason' => 'token', 'messages' => ['Token not provided']], 400);
        });

        Event::listen('tymon.jwt.expired', function () {
            return response()->json(
                ['reason' => 'token', 'messages' => ['Expired Token']], 400);
        });

        Event::listen('tymon.jwt.invalid', function () {
            return response()->json(
                ['reason' => 'token', 'messages' => ['Invalid Token']], 400);
        });
    }
}

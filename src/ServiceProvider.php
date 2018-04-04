<?php

namespace LaravelCustomFaker;

use LaravelCustomFaker\Commands\MakeFakerProvider;
use Illuminate\Support\ServiceProvider as BaseProvider;

class ServiceProvider extends BaseProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register any other events for your application.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeFakerProvider::class,
            ]);
        }
    }
}

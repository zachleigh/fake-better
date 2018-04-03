<?php

namespace LaravelCustomFaker;

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
        $this->registerCommands();
    }

    /**
     * Register any other events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register Artisan commands.
     */
    protected function registerCommands()
    {
        $this->app->singleton('command.make.faker-provider', function ($app) {
            return $app['LaravelPropertyBag\Commands\MakeFakerProvider'];
        });

        $this->commands('command.make.faker-provider');
    }
}

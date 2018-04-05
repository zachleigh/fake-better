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

        $this->registerFakerProviders();
    }

    /**
     * Register all the faker providers listed in the faker provider directory.
     *
     * @return void
     */
    protected function registerFakerProviders()
    {
        if (file_exists(faker_provider_path())) {
            $directory = new \DirectoryIterator(faker_provider_path());

            $faker = app()->get(\Faker\Generator::class);

            foreach ($directory as $file) {
                if ($file->isDot()) {
                    continue;
                }

                require_once $file->getPathname();

                $className = $file->getBaseName('.php');

                if (class_exists($className)) {
                    $faker->addProvider(new $className($faker));
                }
            }
        }
    }
}

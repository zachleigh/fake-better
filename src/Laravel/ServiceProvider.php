<?php

namespace LaravelFakerPlus\Laravel;

use LaravelFakerPlus\Laravel\Commands\MakeFakerProvider;
use Illuminate\Support\ServiceProvider as BaseProvider;
use LaravelFakerPlus\Laravel\Commands\FakerPlusList;
use LaravelFakerPlus\Laravel\Commands\FakerPlusImport;

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
                FakerPlusImport::class,
                FakerPlusList::class,
                MakeFakerProvider::class,
            ]);

            $this->registerFakerProviders();
        }

        $this->publishes([
            __DIR__ . '/config.php' => config_path('faker-plus.php'),
        ]);
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
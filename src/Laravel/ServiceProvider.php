<?php

namespace FakerPlus\Laravel;

use FakerPlus\Laravel\Helpers;
use FakerPlus\Laravel\Commands\FakerPlusList;
use FakerPlus\Laravel\Commands\FakerPlusImport;
use FakerPlus\Laravel\Commands\MakeFakerProvider;
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
        if (file_exists(Helpers::projectProviderPath())) {
            $directory = new \DirectoryIterator(Helpers::projectProviderPath());

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

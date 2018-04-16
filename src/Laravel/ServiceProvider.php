<?php

namespace FakeBetter\Laravel;

use Faker\Generator;
use FakeBetter\Providers\Copy;
use FakeBetter\Laravel\Helpers;
use FakeBetter\Laravel\Commands\FakeBetterList;
use FakeBetter\Laravel\Commands\FakeBetterImport;
use FakeBetter\Laravel\Commands\MakeFakerProvider;
use Illuminate\Support\ServiceProvider as BaseProvider;
use FakeBetter\Laravel\Commands\MakeFakerCopy;

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
                // FakeBetterImport::class,
                // FakeBetterList::class,
                MakeFakerCopy::class,
                MakeFakerProvider::class,
            ]);

            $this->registerFakerProviders();
        }

        $this->publishes([
            __DIR__ . '/config.php' => config_path('faker-plus.php'),
        ], 'config');
    }

    /**
     * Register all the faker providers listed in the faker provider directory.
     *
     * @return void
     */
    protected function registerFakerProviders()
    {
        $faker = app()->get(Generator::class);

        $this->registerCopyProvider($faker)
            ->registerUserProviders($faker);
    }

    /**
     * Register the copy provier.
     *
     * @param Generator $faker
     * @return static
     */
    protected function registerCopyProvider(Generator $faker)
    {
        $copyProvider = new Copy($faker);

        $copyProvider->setCopyPath(Helpers::projectCopyPath());

        $faker->addProvider($copyProvider);

        return $this;
    }

    /**
     * Register user providers.
     *
     * @param Generator $faker
     * @return static
     */
    protected function registerUserProviders(Generator $faker)
    {
        if (file_exists(Helpers::projectProviderPath())) {
            $directory = new \DirectoryIterator(Helpers::projectProviderPath());

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

        return $this;
    }
}

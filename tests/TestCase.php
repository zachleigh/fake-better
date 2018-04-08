<?php

namespace LaravelFakerPlus\Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use LaravelFakerPlus\Laravel\ServiceProvider;
use Illuminate\Filesystem\Filesystem;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../vendor/laravel/laravel/bootstrap/app.php';

        $app->register(ServiceProvider::class);

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * Remove the given path and assert its gone. If directory, remove all files
     * first.
     *
     * @param string $path
     * @return void
     */
    protected function removeFile($path)
    {
        $filesystem = new Filesystem();

        if ($filesystem->exists($path)) {
            if ($filesystem->isDirectory($path)) {
                foreach ($filesystem->allFiles($path) as $file) {
                    $this->removeFile($file);
                }

                $filesystem->deleteDirectory($path);
            } else {
                $filesystem->delete($path);
            }
        }

        $this->assertFileNotExists($path);
    }

    /**
     * Create a provider using an exmple provider in the data directory.
     *
     * @param string $name
     * @return void
     */
    protected function createProvider($name)
    {
        $filesystem = new Filesystem();

        $filesystem->makeDirectory(faker_provider_path());

        $data = $filesystem->get(__DIR__ . "/data/{$name}.php");

        $path = faker_provider_path($name . '.php');

        $filesystem->put($path, $data);

        $this->assertFileExists($path);
    }
}

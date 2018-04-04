<?php

namespace LaravelCustomFaker\Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use LaravelCustomFaker\ServiceProvider;
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
}

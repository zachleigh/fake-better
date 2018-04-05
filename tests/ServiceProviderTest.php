<?php

namespace LaravelRealCopy\Tests;

use Illuminate\Filesystem\Filesystem;
use Faker\Generator;

class ServiceProviderTest extends TestCase
{
    /**
     * Setup the files used by these classes before app is loaded.
     *
     * @return void
     */
    public function setup()
    {
        $filesystem = new Filesystem();

        $filesystem->makeDirectory(dirname(__DIR__) . '/vendor/laravel/laravel/database/faker-providers/');

        $filesystem->copy(
            __DIR__ . '/data/DogNames.php',
            dirname(__DIR__) . '/vendor/laravel/laravel/database/faker-providers/DogNames.php'
        );

        parent::setUp();
    }

    /**
     * @test
     */
    public function userFakerProvidersAreRegistered()
    {
        $maleNames = [
            'Butch',
            'Fiddo',
            'Gandolf',
            'Snoop',
        ];

        $faker = app()->get(Generator::class);

        $this->assertContains($faker->maleDogName, $maleNames);
    }
}

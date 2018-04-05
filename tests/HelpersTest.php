<?php

namespace LaravelRealCopy\Tests;

class HelpersTest extends TestCase
{
    /**
     * @test
     */
    public function fakerProviderPathReturnsPath()
    {
        $this->assertEquals(
            dirname(__DIR__).'/vendor/laravel/laravel/database/faker-providers/',
            faker_provider_path()
        );
    }

    /**
     * @test
     */
    public function fakerProviderPathReturnsPathWithAppendedFile()
    {
        $this->assertEquals(
            dirname(__DIR__) . '/vendor/laravel/laravel/database/faker-providers/Test.php',
            faker_provider_path('Test.php')
        );
    }
}

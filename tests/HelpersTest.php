<?php

namespace FakerPlus\Tests;

use FakerPlus\Laravel\Helpers;

class HelpersTest extends TestCase
{
    /**
     * @test
     */
    public function fakerProviderPathReturnsPath()
    {
        $this->assertEquals(
            dirname(__DIR__).'/vendor/laravel/laravel/database/faker/providers/',
            Helpers::projectProviderPath()
        );
    }

    /**
     * @test
     */
    public function fakerProviderPathReturnsPathWithAppendedFile()
    {
        $this->assertEquals(
            dirname(__DIR__) . '/vendor/laravel/laravel/database/faker/providers/Test.php',
            Helpers::projectProviderPath('Test.php')
        );
    }
}

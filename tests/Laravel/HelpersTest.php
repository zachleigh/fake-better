<?php

namespace FakeBetter\Tests\Laravel;

use FakeBetter\Tests\TestCase;
use FakeBetter\Laravel\Helpers;

class HelpersTest extends TestCase
{
    /**
     * @test
     */
    public function fakerProviderPathReturnsPath()
    {
        $this->assertEquals(
            dirname(__DIR__, 2).'/vendor/laravel/laravel/database/faker/providers/',
            Helpers::projectProviderPath()
        );
    }

    /**
     * @test
     */
    public function fakerProviderPathReturnsPathWithAppendedFile()
    {
        $this->assertEquals(
            dirname(__DIR__, 2).'/vendor/laravel/laravel/database/faker/providers/Test.php',
            Helpers::projectProviderPath('Test.php')
        );
    }
}

<?php

namespace FakerPlus\Tests\Laravel\Commands;

use Faker\Generator;
use FakerPlus\Tests\TestCase;
use FakerPlus\Providers\Colors;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\BufferedOutput;

class FakerPlusListTest extends TestCase
{
    /**
     * @test
     */
    public function fakerPlusListListsAllProvidersThatCanBeImported()
    {
        $output = new BufferedOutput();

        Artisan::call('faker-plus:list', [], $output);

        $colors = new Colors(new Generator());

        $this->assertContains("Colors: {$colors->getDescription()}", $output->fetch());
    }
}

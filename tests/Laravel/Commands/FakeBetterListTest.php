<?php

namespace FakeBetter\Tests\Laravel\Commands;

use Faker\Generator;
use FakeBetter\Tests\TestCase;
use FakeBetter\Providers\Library\Colors;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\BufferedOutput;

class FakeBetterListTest extends TestCase
{
    // /**
    //  * @test
    //  */
    // public function FakeBetterListListsAllProvidersThatCanBeImported()
    // {
    //     $output = new BufferedOutput();

    //     Artisan::call('faker-plus:list', [], $output);

    //     $colors = new Colors(new Generator());

    //     $this->assertContains("Colors: {$colors->getDescription()}", $output->fetch());
    // }
}

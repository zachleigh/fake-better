<?php

namespace LaravelFakerPlus\Tests\Laravel\Commands;

use Faker\Generator;
use LaravelFakerPlus\Tests\TestCase;
use LaravelFakerPlus\Laravel\Helpers;
use LaravelFakerPlus\Providers\Colors;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\BufferedOutput;

class FakerPlusImportTest extends TestCase
{
    /**
     * @test
     */
    public function fakerPlusImportyImportsProvidersIntoProject()
    {
        $path = Helpers::projectProviderPath('Colors.php');

        $this->removeFile($path);

        Artisan::call('faker-plus:import', [
            'name' => 'Colors',
        ]);

        $this->assertFileExists($path);

        $contents = file_get_contents($path);

        $this->assertContains('class Colors extends FakerPlusProvider', $contents);

        $this->removeFile(Helpers::projectProviderPath());
    }
}

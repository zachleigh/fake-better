<?php

namespace FakerPlus\Tests\Laravel\Commands;

use Faker\Generator;
use FakerPlus\Tests\TestCase;
use FakerPlus\Laravel\Helpers;
use FakerPlus\Providers\Colors;
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

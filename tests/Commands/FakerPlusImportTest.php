<?php

namespace LaravelFakerPlus\Tests\Commands;

use Faker\Generator;
use LaravelFakerPlus\Tests\TestCase;
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
        $path = faker_provider_path('Colors.php');

        $this->removeFile($path);

        Artisan::call('faker-plus:import', [
            'name' => 'Colors',
        ]);

        $this->assertFileExists($path);

        $contents = file_get_contents($path);

        $this->assertContains('class Colors extends FakerPlusProvider', $contents);

        $this->removeFile(faker_provider_path());
    }
}

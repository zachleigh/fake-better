<?php

namespace FakeBetter\Tests\Laravel\Commands;

use Faker\Generator;
use FakeBetter\Tests\TestCase;
use FakeBetter\Laravel\Helpers;
use FakeBetter\Providers\Colors;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\BufferedOutput;

class FakeBetterImportTest extends TestCase
{
    /**
     * @test
     */
    public function FakeBetterImportyImportsProvidersIntoProject()
    {
        $path = Helpers::projectProviderPath('Colors.php');

        $this->removeFile($path);

        Artisan::call('faker-plus:import', [
            'name' => 'Colors',
        ]);

        $this->assertFileExists($path);

        $contents = file_get_contents($path);

        $this->assertContains('class Colors extends FakeBetterProvider', $contents);

        $this->removeFile(Helpers::projectProviderPath());
    }
}

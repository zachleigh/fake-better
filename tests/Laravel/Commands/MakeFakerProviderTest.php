<?php

namespace FakeBetter\Tests\Laravel\Commands;

use FakeBetter\Tests\TestCase;
use FakeBetter\Laravel\Helpers;
use Illuminate\Support\Facades\Artisan;

class MakeFakerProviderTest extends TestCase
{
    /**
     * @test
     */
    public function makeFakerProviderMakesProvider()
    {
        $path = Helpers::projectProviderPath('Test.php');

        $this->removeFile($path);

        Artisan::call('make:faker-provider', [
            'name' => 'Test',
        ]);

        $this->assertFileExists($path);

        $contents = file_get_contents($path);

        $this->assertContains('class Test extends Base', $contents);

        $this->removeFile(Helpers::projectProviderPath());
    }
}

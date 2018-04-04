<?php

namespace LaravelCustomFaker\Tests\Commands;

use Illuminate\Support\Facades\Artisan;
use LaravelCustomFaker\Tests\TestCase;

class MakeFakerProviderTest extends TestCase
{
    /**
     * @test
     */
    public function makeFakerProviderMakesProvider()
    {
        $path = faker_provider_path('Test.php');

        $this->removeFile($path);

        Artisan::call('make:faker-provider', [
            'name' => 'Test',
        ]);

        $this->assertFileExists($path);

        $contents = file_get_contents($path);

        $this->assertContains('class Test extends Base', $contents);

        $this->removeFile(faker_provider_path());
    }
}

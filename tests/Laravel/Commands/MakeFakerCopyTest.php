<?php

namespace FakeBetter\Tests\Laravel\Commands;

use FakeBetter\Tests\TestCase;
use FakeBetter\Laravel\Helpers;
use Illuminate\Support\Facades\Artisan;

class MakeFakerCopyTest extends TestCase
{
    /**
     * @test
     */
    public function makeFakerCopyMakesCopyFile()
    {
        $path = Helpers::projectCopyPath('test.php');

        $this->removeFile($path);

        Artisan::call('make:faker-copy', [
            'name' => 'test',
        ]);

        $this->assertFileExists($path);

        $contents = file_get_contents($path);

        $this->assertContains('<?php', $contents);

        $this->removeFile(Helpers::projectCopyPath());
    }
}

<?php

namespace FakeBetter\Laravel\Commands;

use FakeBetter\Laravel\Helpers;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeFakerCopy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:faker-copy {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a faker copy file';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $fullPath = Helpers::projectCopyPath($this->argument('name') . '.php');

        $filesystem = new Filesystem();

        if ($filesystem->exists($fullPath)) {
            $this->error("File {$fullPath} already exists.");

            return;
        }

        if (!$filesystem->exists(Helpers::projectCopyPath())) {
            $filesystem->makeDirectory(Helpers::projectCopyPath(), 0755, true);
        }

        $filesystem->put($fullPath, $this->getStub());
    }

    /**
     * Get the faker copy stub with substituted name.
     *
     * @return string
     */
    protected function getStub()
    {
        $stub = file_get_contents(__DIR__ . '/../../Stubs/CopyStub.php');

        return str_replace('{{Name}}', $this->argument('name'), $stub);
    }
}

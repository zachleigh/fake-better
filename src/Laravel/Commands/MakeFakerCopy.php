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

        $this->makePathToFile($filesystem);
;
        $filesystem->put($fullPath, $this->getStub());
    }

    /**
     * Make the full path to the file.
     *
     * @param Filesystem $filesystem
     * @return void
     */
    protected function makePathToFile($filesystem)
    {
        if (strpos($this->argument('name'), '/') !== false) {
            $path = explode('/', $this->argument('name'));

            array_pop($path);

            $path = implode('/', $path);

            $filesystem->makeDirectory(Helpers::projectCopyPath($path), 0755, true);
        } elseif (!$filesystem->exists(Helpers::projectCopyPath())) {
            $filesystem->makeDirectory(Helpers::projectCopyPath(), 0755, true);
        }
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

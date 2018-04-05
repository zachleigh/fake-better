<?php

namespace LaravelRealCopy\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeFakerProvider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:faker-provider {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a custom faker provider';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $fullPath = faker_provider_path($this->argument('name') . '.php');

        $filesystem = new Filesystem();

        if ($filesystem->exists($fullPath)) {
            $this->error("File {$fullPath} already exists.");

            return;
        }

        if (!$filesystem->exists(faker_provider_path())) {
            $filesystem->makeDirectory(faker_provider_path());
        }

        $contents = $this->getStub();

        $filesystem->put($fullPath, $contents);
    }

    /**
     * Get the faker provider stub with substituted name.
     *
     * @return string
     */
    protected function getStub()
    {
        $stub = file_get_contents(__DIR__.'/../Stubs/ProviderStub.php');

        return str_replace('{{Name}}', $this->argument('name'), $stub);
    }
}
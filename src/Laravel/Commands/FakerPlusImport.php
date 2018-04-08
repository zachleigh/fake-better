<?php

namespace LaravelFakerPlus\Laravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class FakerPlusImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'faker-plus:import {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import the specified Faker provider into your project';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');

        $path = local_faker_provider_path($name . '.php');

        if (!file_exists($path)) {
            throw new \Exception("Provider with name {$name} not found.");
        }

        $filesystem = new Filesystem();

        if (!file_exists(faker_provider_path())) {
            $filesystem->makeDirectory(faker_provider_path(), 0755, true);
        }
        
        $filesystem->copy($path, faker_provider_path($name . '.php'));
    }
}

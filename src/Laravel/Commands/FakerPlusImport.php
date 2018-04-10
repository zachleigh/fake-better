<?php

namespace LaravelFakerPlus\Laravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use LaravelFakerPlus\Laravel\Helpers;

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

        $path = Helpers::localProviderPath($name . '.php');

        if (!file_exists($path)) {
            throw new \Exception("Provider with name {$name} not found.");
        }

        $filesystem = new Filesystem();

        if (!file_exists(Helpers::projectProviderPath())) {
            $filesystem->makeDirectory(Helpers::projectProviderPath(), 0755, true);
        }
        
        $filesystem->copy($path, Helpers::projectProviderPath($name . '.php'));
    }
}

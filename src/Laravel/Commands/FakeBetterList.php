<?php

namespace FakeBetter\Laravel\Commands;

use Faker\Generator;
use FakeBetter\Laravel\Helpers;
use Illuminate\Console\Command;
use FakeBetter\Providers\FakeBetterProvider;

class FakeBetterList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'faker-plus:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all Faker providers available for import';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $directory = new \DirectoryIterator(Helpers::localProviderPath());

        $generator = new Generator();

        foreach ($directory as $file) {
            if ($file->isDot()) {
                continue;
            }

            $className = $file->getBasename('.php');

            $fullName = 'FakeBetter\\Providers\\Library\\' . $className;

            if ($this->isFakeBetterProvider($fullName)) {
                $provider = new $fullName($generator);

                $this->info("{$className}: {$provider->getDescription()}");
            }
        }
    }

    /**
     * Return true if the given class has the FakeBetterProvider as a parent.
     *
     * @param string $fullName
     * @return boolean
     */
    protected function isFakeBetterProvider($fullName)
    {
        $reflection = new \ReflectionClass($fullName);

        return $reflection->isSubclassOf(FakeBetterProvider::class);
    }
}

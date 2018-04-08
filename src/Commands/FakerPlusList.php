<?php

namespace LaravelFakerPlus\Commands;

use Faker\Generator;
use Illuminate\Console\Command;
use LaravelFakerPlus\Providers\FakerPlusProvider;

class FakerPlusList extends Command
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
        $directory = new \DirectoryIterator(local_faker_provider_path());

        $generator = new Generator();

        foreach ($directory as $file) {
            if ($file->isDot()) {
                continue;
            }

            $className = $file->getBasename('.php');

            $fullName = 'LaravelFakerPlus\\Providers\\' . $className;

            if ($this->isFakerPlusProvider($fullName)) {
                $provider = new $fullName($generator);

                $this->info("{$className}: {$provider->getDescription()}");
            }
        }
    }

    /**
     * Return true if the given class has the FakerPlusProvider as a parent.
     *
     * @param string $fullName
     * @return boolean
     */
    protected function isFakerPlusProvider($fullName)
    {
        $reflection = new \ReflectionClass($fullName);

        return $reflection->isSubclassOf(FakerPlusProvider::class);
    }
}

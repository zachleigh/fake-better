<?php

use FakeBetter\Providers\FakeBetterProvider;

class DogNames extends FakeBetterProvider
{
    public function maleDogName()
    {
        $names = [
            'Butch',
            'Fiddo',
            'Gandolf',
            'Snoop',
        ];

        return $names[array_rand($names)];
    }

    public function femaleDogName()
    {
        $names = [
            'Snookems',
            'Bell',
            'Swettie Pie',
            'Killer',
        ];

        return $names[array_rand($names)];
    }
}

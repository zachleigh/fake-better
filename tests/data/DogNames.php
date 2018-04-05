<?php

class DogNames extends \Faker\Provider\Base
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

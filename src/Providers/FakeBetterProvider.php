<?php

namespace FakeBetter\Providers;

use Faker\Provider\Base;

abstract class FakeBetterProvider extends Base
{
    /**
     * Return the provider description.
     *
     * @return string
     */
    public function getDescription()
    {
        if (!property_exists($this, 'description')) {
            throw new \Exception('$description property must be defined.');
        }

        return $this->description;
    }

    /**
     * Set config on object.
     *
     * @param mixed $config
     * @return void
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }
}

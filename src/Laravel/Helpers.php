<?php

namespace LaravelFakerPlus\Laravel;

class Helpers
{
    /**
     * Return the path to the faker provider directory. If path included,
     * append to end of directory path.
     *
     * @param string  $path
     * @return string
     */
    public static function projectProviderPath($path = '')
    {
        $directory = config('faker-plus.provider-path', database_path('faker/providers'));

        return rtrim($directory, '/') . '/' . ltrim($path, '/');
    }

    /**
     * Return the path to the current package provider directory. If path included,
     * append to end of directory path.
     *
     * @param string  $path
     * @return string
     */
    public static function localProviderPath($path = '')
    {
        $directory = __DIR__ . '/../Providers';

        return rtrim($directory, '/') . '/' . ltrim($path, '/');
    }
}

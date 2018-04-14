<?php

namespace FakerPlus\Laravel;

class Helpers
{
    /**
     * Return the path to the faker provider directory. If path included,
     * append to end of directory path.
     *
     * @param string $path
     * @return string
     */
    public static function projectProviderPath($path = '')
    {
        $directory = config('faker-plus.provider-path', database_path('faker/providers'));

        return rtrim($directory, '/') . '/' . ltrim($path, '/');
    }

    /**
     * Return the path to the local package provider directory. If path included,
     * append to end of directory path.
     *
     * @param string $path
     * @return string
     */
    public static function localProviderPath($path = '')
    {
        $directory = __DIR__ . '/../Providers/Library';

        return rtrim($directory, '/') . '/' . ltrim($path, '/');
    }

    /**
     * Return the path to the copy directory. If path included, append to end of
     * directory path.
     *
     * @param string $path
     * @return string
     */
    public static function projectCopyPath($path = '')
    {
        $directory = config('faker-plus.copy-path', database_path('faker/copy'));

        return rtrim($directory, '/') . '/' . ltrim($path, '/');
    }
}

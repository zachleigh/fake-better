<?php

if (!function_exists('faker_provider_path')) {
    /**
     * Return the path to the faker provider directory. If path included,
     * append to end of directory path.
     *
     * @param string  $path
     * @return string
     */
    function faker_provider_path($path = '')
    {
        $directory = config('faker-plus.provider-path', database_path('faker-providers'));

        return rtrim($directory, '/') . '/' . ltrim($path, '/');
    }
}

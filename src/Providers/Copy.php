<?php

namespace FakeBetter\Providers;

use FakeBetter\Laravel\Helpers;
use FakeBetter\Providers\FakeBetterProvider;

class Copy extends FakeBetterProvider
{
    /**
     * The path to the copy directory.
     *
     * @var string
     */
    protected $copyPath;

    /**
     * Associative array of all items in the copy directory.
     *
     * @var array
     */
    protected $copyArray;

    /**
     * Provider description.
     *
     * @var string
     */
    protected $description = 'Use real copy examples to generate fake data.';

    /**
     * Get copy from the copy array.
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    protected function resolveCopy($name, $arguments = [])
    {
        if (empty($this->copyArray)) {
            $this->copyArray = $this->buildCopyArray($this->copyPath);
        }

        if ($name === 'get') {
            return $this->getReturnValue($this->get($arguments));
        } elseif (isset($this->copyArray[$name])) {
            return $this->getReturnValue($this->copyArray[$name]);
        }

        throw new \Exception("Item {$name} not found.");
    }

    /**
     * Get arguments by dot separated path. Goes through __call->resolveCopy to
     * ensure copyArray generation.
     *
     * @param array $arguments
     * @return mixed
     */
    protected function get($arguments)
    {
        if (!$arguments) {
            throw new \Exception('Not enough arguments.');
        }

        $pathArray = explode('.', $arguments[0]);

        $copy = $this->copyArray;

        foreach ($pathArray as $key) {
            if (isset($copy[$key])) {
                $copy = $copy[$key];
            } else {
                throw new \Exception("Path {$arguments[0]} invalid.");
            }
        }

        return $copy;
    }

    /**
     * Build the copy array.
     *
     * @param string $path
     * @param array $array
     * @return array
     */
    protected function buildCopyArray($path, $array = [])
    {
        $directory = new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS);

        foreach ($directory as $filePath => $file) {
            if ($file->isDir()) {
                $array[$file->getBasename()] = $this->buildCopyArray($filePath);
            } else {
                $array[$file->getBasename('.php')] = require $file->getPathname();
            }
        }

        return $array;
    }

    /**
     * Set the path to the copy directory on the object.
     *
     * @param string $path
     * @return void
     */
    public function setCopyPath($path)
    {
        $this->copyPath = $path;
    }

    /**
     * Randomize return value if given value is array. Simply return value otherwise.
     *
     * @param mixed $value
     * @return mixed
     */
    protected function getReturnValue($value)
    {
        if (is_array($value)) {
            return $value[array_rand($value)];
        }
        
        return $value;
    }

    /**
     * Magic call.
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->resolveCopy($name, $arguments);
    }

    /**
     * Magic get.
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->resolveCopy($name);
    }

    /**
     * Use this class as a function to call get.
     *
     * @param string $path
     * @return mixed
     */
    public function __invoke($path = '')
    {
        return $this->resolveCopy('get', [$path]);
    }
}

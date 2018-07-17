<?php

namespace Snegovoy\App;

use  Snegovoy\App\KeyValueStorageInterface;

class JsonKeyValueStorage implements KeyValueStorageInterface
{
    private $storage = [];
    private $pathToFile;

    public function __construct(string $pathToFile)
    {
        $this->pathToFile = $pathToFile;
    }

    public function set(string $key, $value): void
    {
        $this->storage[$key] = $value;
        $this->writeToFile($this->storage);
    }

    public function get(string $key)
    {
         if ($this->has($key)) {
             return $this->storage[$key];
         }
         return null;
    }

    public function has(string $key): bool
    {
        $this->storage = $this->readFromFile();
        return isset($this->storage[$key]);
    }

    public function remove(string $key):void
    {
            $content = $this->readFromFile();
        if (isset($content[$key])) {
            unset($this->storage[$key]);
            $this->writeToFile($this->storage);
        }
    }

    public function clear(): void
    {
        \file_put_contents($this->pathToFile, '', \LOCK_EX);
    }

    private function encodeData(array $array)
    {
        return json_encode($array);
    }

    private function writeToFile(array $array): void
    {
        \file_put_contents($this->pathToFile, $array, \LOCK_EX);
    }

    private function readFromFile()
    {
        $content = \file_get_contents($this->pathToFile);
        return json_decode($content,true);

    }

}

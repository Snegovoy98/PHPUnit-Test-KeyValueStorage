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
        $this->storage = $this->readFromFile();
        $this->storage[$key] = \is_object($value) ? \serialize($value) : $value;
        $this->writeToFile($this->storage);
    }

    public function get(string $key)
    {
         if ($this->has($key)) {
             $value = $this->storage[$key];
             if (\is_string($value) && $object = @\unserialize($value)) {
                 return $object;
             }
             return $value;
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

    private function writeToFile(array $array): void
    {
        $json = \json_encode($array, \JSON_PRETTY_PRINT);
        \file_put_contents($this->pathToFile, $json, \LOCK_EX);
    }

    private function readFromFile()
    {
        $storage = \file_get_contents($this->pathToFile);
        $data = \json_decode($storage, true);
        return \is_array($data) ? $data : [];
    }
}

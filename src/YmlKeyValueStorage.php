<?php

namespace Snegovoy\App;

use  Snegovoy\App\KeyValueStorageInterface;
use Symfony\Component\Yaml\Yaml;

class YmlKeyValueStorage  implements KeyValueStorageInterface
{
    private $storage = [];
    private $pathToFile;

    public function __construct($pathToFile)
    {
        $this->pathToFile = $pathToFile;
    }

    public function set(string  $key, $value): void
    {
        $data = $this->parseYmlInPHP();
        if($data[$key] != $this->storage[$key]){
            $this->storage[$key] = $value;
            $this->writeToFile($this->storage);
        }

    }

    public function get(string $key)
    {
        if ($this->has($key)) {
            return $this->storage[$key];
        }
        return null;
    }

    public function has(string  $key):bool
    {
        $this->storage=$this->parseYmlInPHP();
        return isset($this->storage[$key]);

    }

    public function remove(string $key): void
    {
        $content = $this->parseYmlInPHP();
        if (isset($content[$key])) {
              unset($this->storage[$key]);
             $this->writeToFile($this->storage);
        }
    }

    public function clear(): void
    {
        \file_put_contents($this->pathToFile, '', \LOCK_EX);
    }

    private function dumpInYml(array $array)
    {
       return Yaml::dump($array,1);
    }

    private function writeToFile(array $array): void
    {
        \file_put_contents($this->pathToFile, $array, \LOCK_EX);
    }

    private function parseYmlInPHP()
    {
      return Yaml::parseFile($this->pathToFile);
    }
}
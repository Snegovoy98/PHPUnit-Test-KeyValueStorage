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

    /**
     * Use for testing method which set data
     *method testSet
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string  $key, $value): void
    {
            $this->storage[$key] = $value;
            $this->writeToFile($this->storage);
    }

    /**
     * Use for testing method which get data
     *method testGet
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        if ($this->has($key)) {
            return $this->storage[$key];
        }
        return null;
    }

    /**
     * Use for testing method which has data
     *method testHas
     *  @param string $key
     * @return bool
     */
    public function has(string  $key): bool
    {
        $this->storage=$this->parseYmlInPHP();
        return isset($this->storage[$key]);

    }
    /**Use for testing method which remove data
     *method testRemove
     * @param string $key
     * @return void
     */
    public function remove(string $key): void
    {
        $content = $this->parseYmlInPHP();
        if (isset($content[$key])) {
              unset($this->storage[$key]);
             $this->writeToFile($this->storage);
        }
    }

    /**A  test method that use for completely cleans up the storage
     * testClear
     * @return void
     */
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
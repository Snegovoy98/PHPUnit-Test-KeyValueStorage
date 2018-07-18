<?php

namespace Snegovoy\App;

use Snegovoy\App\KeyValueStorageInterface;
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
            $this->storage = $this->parseYmlInPHP();
            $this->storage[$key] = \is_object($value) ? \serialize($value) : $value;
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
        $this->storage=$this->parseYmlInPHP();
        if ($this->has($key)) {
            $value = $this->storage[$key];
            if (\is_string($value) && $object = @\unserialize($value)) {
                return $object;
            }
            return $value;
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

    private function writeToFile(array $array) :void
    {
        $yaml = Yaml::dump($array);
        \file_put_contents($this->pathToFile, $yaml, \LOCK_EX);
    }

    private function parseYmlInPHP(): array
    {
        $data = Yaml::parseFile($this->pathToFile);
        return \is_array($data) ? $data : [];
    }
}
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
        $this->storage[$key] = $value;
        $this->writeToFile($this->storage,'r+');
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
        if ($this->has($key)) {
            $content = $this->parseYmlInPHP();
            foreach ($content as $data_key => $value) {
                if ($data_key == $key) {
                    unset($this->storage[$key]);
                    $this->writeToFile($this->storage,'w+');
                }
            }
        }
    }

    public function clear(): void
    {
        $this->storage = [];
        $fp = fopen($this->pathToFile,'w+');
        ftruncate($fp, filesize($this->pathToFile));
        fclose($fp);
    }

    private function dumpInYml(array $array)
    {
       return Yaml::dump($array,1);
    }

    private function writeToFile(array $array, $flag): void
    {
        $fp = fopen($this->pathToFile, $flag);
        fwrite($fp, $this->dumpInYml($array), strlen($this->dumpInYml($array)));
        fclose($fp);
    }

    private function parseYmlInPHP()
    {
      return Yaml::parseFile($this->pathToFile);
    }
}
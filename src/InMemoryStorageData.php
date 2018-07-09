<?php

namespace Snegovoy\App;

use  Snegovoy\App\KeyValueStorageInterface;

class InMemoryStorageData implements KeyValueStorageInterface
{
    private $storage = [] ;

    public function set(string $key, $value): void
    {
       $this->storage[$key] = $value;

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
      return isset($this->storage[$key]);

    }

    public function remove(string $key): void
    {
        if ($this->has($key)) {
            unset($this->storage[$key]);
        }
    }

    public function clear(): void
    {
         $this->storage=[];
    }
}

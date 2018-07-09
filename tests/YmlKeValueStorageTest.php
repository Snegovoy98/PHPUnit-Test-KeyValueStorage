<?php

namespace Snegovoy\App\Tests;

use Snegovoy\App\YmlKeyValueStorage;
use PHPUnit\Framework\TestCase;

class YmlKeValueStorageTest extends TestCase
{
    private $storage ;

    public function __construct()
    {
        $this->storage = new YmlKeyValueStorage(__DIR__ . '../data/storage.yaml');
    }

    public function testSet()
    {
        $this->storage->set('email', 'Ivanov77@gmail.com');
    }

    public function testGet()
    {

    }

    public function testHas()
    {

    }

    public function testRemove()
    {
        
    }

    public function testClear()
    {
        
    }
}
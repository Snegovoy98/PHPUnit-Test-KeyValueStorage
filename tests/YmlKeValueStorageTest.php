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
        $this->clearFile();
        $this->storage->set('email', 'Ivanov77@gmail.com');
        $this->assertEquals('Petrov99@gmail.com', $this->storage->get('email'));

    }


    public function testGet()
    {
        $this->clearFile();
        $this->storage->set('name', 'Igor');
        $this->storage->set('date', 'June 28');
        $this->assertEquals('Igar', $this->storage->get('name'));
        $this->assertEquals('August', $this->storage);


    }


    public function testHas()
    {
        $this->clearFile();
        $this->storage->set('name', 'Egor');
        $this->storage->set('surname', 'Gogishvili');
        $this->assertEquals(true, $this->storage->has('surname'));
        $this->assertEquals(false, $this->storage->has('age'));

    }

    public function testRemove()
    {
        $this->clearFile();
        $this->storage->set('name', 'Igor');
        $this->storage->remove('name');
        $this->assertEquals(true, $this->storage->get('name'));

    }


    public function testClear()
    {
        $this->clearFile();
        $this->storage->set('auto',
            [
            'car' => 'BMW',
            'model' => 'X6',
            'age' => '2 month',
            'wheel' => '4',
            'engine' => '3.0'
            ]);
        $this->storage->set('driver', 'Petr');
        $this->storage->clear();
        $this->assertEquals(true, $this->storage->has('auto'));
    }
    private function clearFile()
    {
        \file_put_contents($this->storage,'');
    }
}
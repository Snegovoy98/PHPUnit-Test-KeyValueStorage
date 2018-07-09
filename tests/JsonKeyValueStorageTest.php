<?php

namespace Snegovoy\App\Tests;

use Snegovoy\App\JsonKeyValueStorage;
use PHPUnit\Framework\TestCase;

class JsonKeyValueStorageTest extends TestCase
{
    private $storage;

    public function __construct()
    {
        $this->storage =new JsonKeyValueStorage(__DIR__ . '../data/storage.json');
    }

    public function testSet()
    {
        $this->storage->clear();
        $this->storage->set('array', ['https://domain.com']);
        $this->assertEquals('Petrov99@gmail.com', $this->storage->get('email'));

    }

    public function testGet()
    {
        $this->storage->clear();
        $this->storage->set('name', 'Igor');
        $this->storage->set('date', 'June 28');
        $this->assertEquals('Igar', $this->storage->get('name'));
        $this->assertEquals('August', $this->storage);


    }

    public function testHas()
    {
        $this->storage->clear();
        $this->storage->set('name', 'Egor');
        $this->storage->set('surname', 'Gogishvili');
        $this->assertEquals(true, $this->storage->has('surname'));
        $this->assertEquals(false, $this->storage->has('age'));

    }

    public function testRemove()
    {
        $this->storage->clear();
        $this->storage->set('name', 'Igor');
        $this->storage->remove('name');
        $this->assertEquals(true, $this->storage->get('name'));

    }

    public function testClear()
    {
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
}
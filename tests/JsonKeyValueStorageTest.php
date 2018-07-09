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
        $this->storage->set('array', ['domain.com', 'web_developer.com.ua', 'php_develop.com']);
        $this->assertEquals(['domain.com'], $this->storage->get('array'));

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
        $this->storage->set('car', 'Audi');
        $this->storage->set('mode', 'R8');
        $this->assertEquals(true, $this->storage->has('car'));
        $this->assertEquals(false, $this->storage->has('model'));

    }

    public function testRemove()
    {
        $this->clearFile();
        $this->storage->set('date', 'June');
        $this->storage->remove('date');
        $this->assertEquals(true, $this->storage->get('date'));

    }

    public function testClear()
    {
        $this->storage->set('products', ['Iphone', 'Mac', 'AppWatch']);
        $this->storage->set('producer', 'Apple');
        $this->storage->clear();
        $this->assertEquals(true, $this->storage->has('producer'));
    }

    private function clearFile()
    {
        \file_put_contents($this->storage,'');
    }
}
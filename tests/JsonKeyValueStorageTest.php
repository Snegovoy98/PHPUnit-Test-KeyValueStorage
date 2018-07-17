<?php

namespace Snegovoy\App\Tests;

use Snegovoy\App\JsonKeyValueStorage;
use PHPUnit\Framework\TestCase;

class JsonKeyValueStorageTest extends TestCase
{
    protected const Path_To_File = __DIR__.'/../data/storage.json';

    /**
     * @var JsonKeyValueStorage
     */
    protected  $storage ;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->storage = new JsonKeyValueStorage(self::Path_To_File);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        \file_put_contents(self::Path_To_File, \LOCK_EX);
    }

    /**
     * @expectedException \Snegovoy\App\Test
     * @expectedExceptionMessage You should specify path to file
     */
    public function testSet()
    {
        $this->storage->set('number', 10);
        self::assertEquals(10, $this->storage->get('number'));
    }

    public function testGet()
    {
        $this->storage->set('name', 'Igor');
        $this->storage->set('date', 'June 28');
        self::assertEquals('Igor', $this->storage->get('name'));
        self::assertEquals('August', $this->storage->get('data'));
    }

    public function testHas()
    {
        $this->storage->set('car', 'Audi');
        $this->storage->set('mode', 'R8');
        self::assertTrue(true, $this->storage->has('car'));
        self::assertTrue(true, $this->storage->has('model'));

    }

    public function testRemove()
    {
        $this->storage->set('date', 'June');
        $this->storage->remove('date');
        self::assertFalse(true, $this->storage->get('date'));
    }

    public function testClear()
    {
        $this->storage->set('products', ['Iphone', 'Mac', 'App Watch']);
        $this->storage->set('producer', 'Apple');
        $this->storage->clear();
        self::assertFalse(true, $this->storage->has('products'));
        self::assertFalse(true, $this->storage->has('producer'));
    }
}
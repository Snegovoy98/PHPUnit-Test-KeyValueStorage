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
     * @expectedExceptionMessage You should specify path to file
     */
    public function testSet()
    {
        $this->storage->set('number', 10);
        self::assertEquals(10, $this->storage->get('number'));
        $this->storage->set('message', 'You have a message');
        self::assertEquals('You have a message', $this->storage->get('message'));
    }

    public function testGet()
    {
        $this->storage->set('name', 'Ivan');
        self::assertEquals('Ivan', $this->storage->get('name'));
        $this->storage->set('date', 'June 28');
        self::assertEquals('June 28', $this->storage->get('date'));
        self::assertNull($this->storage->get('unknown'));
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
        self::assertFalse($this->storage->has('date'));
    }

    public function testClear()
    {
        $this->storage->set('product',  'Mac');
        $this->storage->set('producer', 'Apple');
        $this->storage->clear();
        self::assertFalse($this->storage->has('product'));
        self::assertFalse($this->storage->has('producer'));
    }
}
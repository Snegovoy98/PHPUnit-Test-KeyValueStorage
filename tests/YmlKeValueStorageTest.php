<?php

namespace Snegovoy\App\Tests;

use Snegovoy\App\YmlKeyValueStorage;
use PHPUnit\Framework\TestCase;

class YmlKeValueStorageTest extends TestCase
{
    protected const Path_To_File = __DIR__.'/../data/storage.yaml';
    /**
     * @var YmlKeyValueStorage
     */
    protected $storage ;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->storage = new YmlKeyValueStorage(self::Path_To_File);

    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        \file_put_contents(self::Path_To_File, \LOCK_EX);
    }

    public function testSet()
    {
        $this->storage->set('email', 'Ivanov77@gmail.com');
        self::assertEquals('Ivanov77@gmail.com', $this->storage->get('email'));

    }

    /**
     * @expectedException \Snegovoy\App\Test
     * @expectedExceptionMessage You should specify path to file
     */
    public function testGet()
    {
        $this->storage->set('name', 'Igor');
        $this->storage->set('date', 'June 28');
        self::assertEquals('Igor', $this->storage->get('name'));
        self::assertEquals('June 28', $this->storage->get('date'));
    }

    public function testHas()
    {
        $this->storage->set('name', 'Egor');
        $this->storage->set('surname', 'Gogishvili');
        self::assertTrue(true, $this->storage->has('surname'));
        self::assertTrue(true, $this->storage->has('name'));
    }

    public function testRemove()
    {
        $this->storage->set('name', 'Igor');
        $this->storage->remove('name');
        self::assertFalse(true, $this->storage->get('name'));
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
        self::assertTrue(false, $this->storage->has('auto'));
        self::assertTrue(false, $this->storage->get('driver'));
    }
}
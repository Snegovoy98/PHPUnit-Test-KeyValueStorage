<?php

namespace Snegovoy\App\Tests;

use Snegovoy\App\YmlKeyValueStorage;
use PHPUnit\Framework\TestCase;

class YmlKeyValueStorageTest extends TestCase
{
    protected const Path_To_File = __DIR__.'/../data/storage.yaml';
    /**
     * @var YmlKeyValueStorageTest
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
     * @expectedExceptionMessage You should specify path to file
     */
    public function testGet()
    {
        $this->storage->set('name', 'Igor');
        self::assertEquals('Igor', $this->storage->get('name'));
        $this->storage->set('date', 'June 28');
        self::assertEquals('June 28', $this->storage->get('date'));
    }

    public function testHas()
    {
        $this->storage->set('name', 'Egor');
        self::assertTrue($this->storage->has('name'));
        $this->storage->set('surname', 'Gogishvili');
        self::assertTrue($this->storage->has('surname'));

    }

    public function testRemove()
    {
        $this->storage->set('name', 'Igor');
        $this->storage->remove('name');
        self::assertFalse( $this->storage->has('name'));
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
        self::assertFalse( $this->storage->has('auto'));
        self::assertFalse( $this->storage->has('driver'));
    }
}
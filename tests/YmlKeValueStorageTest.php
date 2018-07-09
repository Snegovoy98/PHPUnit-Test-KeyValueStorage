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

    /**Use for testing method which set data
     *method testSet
     */
    public function testSet()
    {
        $this->storage->set('email', 'Ivanov77@gmail.com');
        $this->assertEquals('Petrov99@gmail.com', $this->storage->get('email'));
        $this->storage->clear();
    }

    /**Use for testing method which get data
     *method testGet
     */
    public function testGet()
    {
        $this->storage->set('name', 'Igor');
        $this->storage->set('date', 'June 28');
        $this->assertEquals('Igar', $this->storage->get('name'));
        $this->assertEquals('August', $this->storage);
        $this->storage->clear();

    }

    /**Use for testing method which has data
     *method testHas
     */
    public function testHas()
    {
        $this->storage->set('name', 'Egor');
        $this->storage->set('surname', 'Gogishvili');
        $this->assertEquals(true, $this->storage->has('surname'));
        $this->assertEquals(false, $this->storage->has('age'));
        $this->storage->clear();
    }
    /**Use for testing method which remove data
     *method testRemove
     */
    public function testRemove()
    {
        $this->storage->set('name', 'Igor');
        $this->storage->remove('name');
        $this->assertEquals(true, $this->storage->get('name'));
        $this->storage->clear();
    }

    /**A  test method that use for completely cleans up the storage
     * testClear
     */
    public function testClear()
    {
        $this->storage->set('auto', [
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
<?php

namespace Fig\Cache\Test;

use Fig\Cache\MemoryPool;

class MemoryPoolTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Verifies that a cache miss returns NULL.
     */
    public function testEmptyItem()
    {
        $pool = new MemoryPool();

        $this->assertFalse($pool->hasItem('foo'));

        $item = $pool->getItem('foo');

        $this->assertNull($item->get());
    }

    /**
     * Verifies that primitive items can be added and retrieved from the pool.
     *
     * @dataProvider providerPrimitiveValues
     */
    public function testAddItem($value, $type)
    {
        $pool = new MemoryPool();

        $item = $pool->getItem('foo');
        $item->set($value);
        $pool->save($item);

        $item = $pool->getItem('foo');
        $this->assertEquals($value, $item->get());
        $this->assertEquals($type, gettype($item->get()));
    }

    /**
     * Provides a set of test values for saving and retrieving.
     *
     * @return array
     */
    public function providerPrimitiveValues()
    {
        return [
            ['bar', 'string'],
            [1, 'integer'],
            [3.141592, 'double'],
            [['a', 'b', 'c'], 'array'],
            [['a' => 'A', 'b' => 'B', 'c' => 'C'], 'array'],
        ];
    }

}

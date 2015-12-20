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
        $this->assertFalse($item->isHit());
    }

    /**
     * Verifies that primitive items can be added and retrieved from the pool.
     *
     * @param mixed $value
     *   A value to try and cache.
     * @param string $type
     *   The type of variable we expect to be cached.
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

    /**
     * Verifies that an item with an expiration time in the past won't be retrieved.
     *
     * @param mixed $value
     *   A value to try and cache.
     *
     * @dataProvider providerPrimitiveValues
     */
    public function testExpiresAt($value)
    {
        $pool = new MemoryPool();

        $item = $pool->getItem('foo');
        $item
            ->set($value)
            ->expiresAt(new \DateTime('-1 minute'));
        $pool->save($item);

        $item = $pool->getItem('foo');
        $this->assertNull($item->get());
        $this->assertFalse($item->isHit());
    }
}

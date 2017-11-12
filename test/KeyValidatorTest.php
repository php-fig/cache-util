<?php

namespace Fig\Cache\Test;

use Fig\Cache\Memory\MemoryPool;
use Fig\Cache\Memory\MemoryCacheItem;
use Fig\Cache\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class KeyValidatorTest extends TestCase
{
    /** @var MemoryPool */
    protected $pool;

    protected function setUp()
    {
        $this->pool = new MemoryPool();
    }

    /**
     * Verifies key's name in positive cases.
     *
     * @param string $key
     *   The key's name.
     *
     * @dataProvider providerValidKeyNames
     */
    public function testPositiveValidateKey($key)
    {
        $this->assertInstanceOf(MemoryCacheItem::class, $this->pool->getItem($key));
    }

    /**
     * Provides a set of valid test key names.
     *
     * @return array
     */
    public function providerValidKeyNames()
    {
        return [
            ['bar'],
            ['barFoo1234567890'],
            ['bar_Foo.1'],
            ['1'],
            [str_repeat('a', 64)]
        ];
    }

    /**
     * Verifies key's name in negative cases.
     *
     * @param string $key
     *   The key's name.
     *
     * @expectedException InvalidArgumentException
     * @dataProvider providerNotValidKeyNames
     */
    public function testNegativeValidateKey($key)
    {
        $this->pool->getItem($key);
    }

    /**
     * Provides a set of not valid test key names.
     *
     * @return array
     */
    public function providerNotValidKeyNames()
    {
        return [
            [null],
            [1],
            [''],
            ['bar{Foo'],
            ['bar}Foo'],
            ['bar(Foo'],
            ['bar)Foo'],
            ['bar/Foo'],
            ['bar\Foo'],
            ['bar@Foo'],
            ['bar:Foo']
        ];
    }
}

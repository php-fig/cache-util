<?php

namespace Fig\Cache\Test;

use Fig\Cache\InvalidArgumentException;
use Fig\Cache\Memory\MemoryCacheItem;
use Fig\Cache\Memory\MemoryPool;
use PHPUnit\Framework\TestCase;

class KeyValidatorTest extends TestCase
{
    /** @var MemoryPool */
    protected $pool;

    protected function setUp(): void
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
        static::assertInstanceOf(MemoryCacheItem::class, $this->pool->getItem($key));
    }

    /**
     * Provides a set of valid test key names.
     *
     * @return array
     */
    public function providerValidKeyNames(): array
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
    public function testNegativeValidateKey($key): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->pool->getItem($key);
    }

    /**
     * Provides a set of not valid test key names.
     *
     * @return array
     */
    public function providerNotValidKeyNames(): array
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

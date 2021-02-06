<?php

namespace Fig\Cache\Test;

use Fig\Cache\CachePoolDeferTrait;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemInterface;

class CachePoolDeferTraitTest extends TestCase
{
    private $traitStub;
    private $itemStub;

    public function setUp(): void
    {
        $this->traitStub = $this->getMockForTrait(CachePoolDeferTrait::class);
        $this->itemStub = $this->createMock(CacheItemInterface::class);
    }

    public function testSaveSuccess(): void
    {
        $this->traitStub->expects(static::once())
            ->method('write')
            ->with(static::equalTo([$this->itemStub]))
            ->willReturn(true);
        static::assertTrue($this->traitStub->save($this->itemStub));
    }

    public function testSaveFail(): void
    {
        $this->traitStub->expects(static::once())
            ->method('write')
            ->willReturn(false);
        static::assertFalse($this->traitStub->save($this->itemStub));
    }

    public function testSaveDeferred(): void
    {
        static::assertTrue($this->traitStub->saveDeferred($this->itemStub));
    }

    public function testCommitSuccess(): void
    {
        $otherItem = clone $this->itemStub;
        $this->traitStub->expects(static::once())
            ->method('write')
            ->with(static::equalTo([$this->itemStub, $otherItem]))
            ->willReturn(true);

        $this->traitStub->saveDeferred($this->itemStub);
        $this->traitStub->saveDeferred($otherItem);
        static::assertTrue($this->traitStub->commit());
    }

    public function testCommitFail(): void
    {
        $this->traitStub->expects(static::once())
            ->method('write')
            ->willReturn(false);

        $this->traitStub->saveDeferred($this->itemStub);
        static::assertFalse($this->traitStub->commit());
    }
}

<?php

namespace Fig\Cache\Test;

use Fig\Cache\CachePoolDeferTrait;
use Prophecy\Argument;
use Psr\Cache\CacheItemInterface;

class CachePoolDeferTraitTest extends \PHPUnit_Framework_TestCase
{
    private $traitStub;
    private $itemStub;

    public function setUp()
    {
        $this->traitStub = $this->getMockForTrait(CachePoolDeferTrait::class);
        $this->itemStub = $this->getMock(CacheItemInterface::class);
    }

    public function testSaveSuccess()
    {
        $this->traitStub->expects($this->once())
            ->method('write')
            ->with($this->equalTo([$this->itemStub]))
            ->will($this->returnValue(true));
        $this->assertTrue($this->traitStub->save($this->itemStub));
    }

    public function testSaveFail()
    {
        $this->traitStub->expects($this->once())
            ->method('write')
            ->will($this->returnValue(false));
        $this->assertFalse($this->traitStub->save($this->itemStub));
    }

    public function testSaveDeferred()
    {
        $this->assertTrue($this->traitStub->saveDeferred($this->itemStub));
    }

    public function testCommitSuccess()
    {
        $otherItem = clone $this->itemStub;
        $this->traitStub->expects($this->once())
            ->method('write')
            ->with($this->equalTo([$this->itemStub, $otherItem]))
            ->will($this->returnValue(true));

        $this->traitStub->saveDeferred($this->itemStub);
        $this->traitStub->saveDeferred($otherItem);
        $this->assertTrue($this->traitStub->commit());
    }

    public function testCommitFail()
    {
        $this->traitStub->expects($this->once())
            ->method('write')
            ->will($this->returnValue(false));

        $this->traitStub->saveDeferred($this->itemStub);
        $this->assertFalse($this->traitStub->commit());
    }
}

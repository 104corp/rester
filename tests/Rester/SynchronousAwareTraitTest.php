<?php

namespace Tests\Rester;

use Corp104\Rester\Support\SynchronousAwareTrait;
use Tests\Fixture\TestResterClientWithoutSynchronousAwareInterface;
use Tests\Fixture\TestResterClientWithSynchronousAwareInterface;
use Tests\TestCase;

class SynchronousAwareTraitTest extends TestCase
{
    /**
     * @var SynchronousAwareTrait
     */
    protected $target;

    public function trueAndFalse()
    {
        return [
            [true],
            [false],
        ];
    }

    protected function setUp()
    {
        parent::setUp();

        $this->target = $this->getMockForTrait(\Corp104\Rester\Support\SynchronousNullTrait::class);
    }

    protected function tearDown()
    {
        $this->target = null;

        parent::tearDown();
    }

    /**
     * @test
     */
    public function shouldReturnNullWhenGetSyncDefault()
    {
        $this->assertNull($this->target->getSynchronous());
    }

    /**
     * @test
     * @dataProvider trueAndFalse
     */
    public function shouldPutSyncDoNothingWhenClientIsNotImplementSyncInterface($trueAndFalse)
    {
        $clientMock = $this->getMockBuilder(TestResterClientWithoutSynchronousAwareInterface::class)
            ->getMock();

        $clientMock->expects($this->never())
            ->method('setSynchronous');

        $clientMock->method('getSynchronous')
            ->willReturn(null);

        $this->target->setSynchronous($trueAndFalse);
        $this->target->transferSynchronousStatusTo($clientMock);
    }

    /**
     * @test
     */
    public function shouldPutSyncDoNothingWhenCollectionSyncIsNull()
    {
        $clientMock = $this->getMockBuilder(TestResterClientWithSynchronousAwareInterface::class)
            ->getMock();

        $clientMock->expects($this->never())
            ->method('setSynchronous');

        $this->target->transferSynchronousStatusTo($clientMock);
    }

    /**
     * @test
     * @dataProvider trueAndFalse
     */
    public function shouldPutSyncDoNothingWhenCollectionSyncIsNotNullAndClientSyncIsSet($trueAndFalse)
    {
        $clientMock = $this->getMockBuilder(TestResterClientWithSynchronousAwareInterface::class)
            ->getMock();

        $clientMock->expects($this->never())
            ->method('setSynchronous');

        $clientMock->method('getSynchronous')
            ->willReturn($trueAndFalse);

        $this->target->synchronous();
        $this->target->transferSynchronousStatusTo($clientMock);

        $this->target->asynchronous();
        $this->target->transferSynchronousStatusTo($clientMock);
    }

    /**
     * @test
     * @dataProvider trueAndFalse
     */
    public function shouldPutSyncWhenCollectionSyncIsNotNullAndClientSyncIsNull($trueAndFalse)
    {
        $clientMock = $this->getMockBuilder(TestResterClientWithSynchronousAwareInterface::class)
            ->getMock();

        $clientMock->expects($this->once())
            ->method('setSynchronous');

        $clientMock->method('getSynchronous')
            ->willReturn(null);

        $this->target->setSynchronous($trueAndFalse);
        $this->target->transferSynchronousStatusTo($clientMock);
    }
}

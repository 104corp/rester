<?php

namespace Tests\Rester;

use Corp104\Rester\Collection;
use Tests\Fixture\TestResterClientWithoutSynchronousAwareInterface;
use Tests\Fixture\TestResterClientWithSynchronousAwareInterface;
use Tests\TestCase;

class CollectionTest extends TestCase
{
    /**
     * @var Collection
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

        $this->target = new Collection();
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
        $this->target->set('whatever', $clientMock);
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

        $this->target->set('whatever', $clientMock);
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
        $this->target->set('whatever', $clientMock);

        $this->target->asynchronous();
        $this->target->set('whatever', $clientMock);
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
        $this->target->set('whatever', $clientMock);
    }
}

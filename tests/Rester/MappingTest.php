<?php

namespace Tests\Rester;

use Corp104\Rester\Api\Api;
use Corp104\Rester\Api\Path;
use Corp104\Rester\Exceptions\ApiNotFoundException;
use Corp104\Rester\Mapping;
use Tests\Fixture\TestResterClientWithSynchronousAwareInterface;
use Tests\TestCase;

class MappingTest extends TestCase
{
    /**
     * @var Mapping
     */
    protected $target;

    protected function setUp()
    {
        parent::setUp();

        $this->target = new Mapping();
    }

    protected function tearDown()
    {
        $this->target = null;

        parent::tearDown();
    }

    public function trueAndFalse()
    {
        return [
            [true],
            [false],
        ];
    }

    /**
     * @test
     */
    public function shouldThrowInvalidApiExceptionWhenApiNotFound()
    {
        $this->expectException(ApiNotFoundException::class);

        $this->target->get('UnknownApi');
    }

    /**
     * @test
     */
    public function shouldGetEmptyArrayWhenGetApiListFirst()
    {
        $this->assertEquals([], $this->target->all());
    }

    /**
     * @test
     */
    public function shouldGetOneApiListWhenAfterSetOneApiList()
    {
        $exceptedApiName = 'some-api';
        $exceptedCount = 1;

        $this->target->set($exceptedApiName, new Path('GET', $exceptedApiName));
        $actualApiList = $this->target->all();

        $this->assertArrayHasKey($exceptedApiName, $actualApiList);
        $this->assertCount($exceptedCount, $actualApiList);
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
     */
    public function shouldPutSyncDoNothingWhenCollectionSyncIsNull()
    {
        $apiMock = $this->createMock(Api::class);

        $apiMock->expects($this->never())
            ->method('setSynchronous');

        $this->target->set('whatever', $apiMock);
    }

    /**
     * @test
     * @dataProvider trueAndFalse
     */
    public function shouldPutSyncDoNothingWhenCollectionSyncIsNotNullAndClientSyncIsSet($trueAndFalse)
    {
        $apiMock = $this->createMock(Api::class);

        $apiMock->expects($this->never())
            ->method('setSynchronous');

        $apiMock->method('getSynchronous')
            ->willReturn($trueAndFalse);

        $this->target->synchronous();
        $this->target->set('whatever', $apiMock);

        $this->target->asynchronous();
        $this->target->set('whatever', $apiMock);
    }

    /**
     * @test
     * @dataProvider trueAndFalse
     */
    public function shouldPutSyncWhenCollectionSyncIsNotNullAndClientSyncIsNull($trueAndFalse)
    {
        $apiMock = $this->createMock(Api::class);

        $apiMock->expects($this->once())
            ->method('setSynchronous');

        $apiMock->method('getSynchronous')
            ->willReturn(null);

        $this->target->setSynchronous($trueAndFalse);
        $this->target->set('whatever', $apiMock);
    }
}

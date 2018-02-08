<?php

namespace Tests\Rester;

use Corp104\Rester\Api;
use Corp104\Rester\Exception\ApiNotFoundException;
use Corp104\Rester\Mapping;
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

    /**
     * @test
     */
    public function shouldThrowInvalidApiExceptionWhenApiNotFound()
    {
        // Arrange
        $this->expectException(ApiNotFoundException::class);

        // Act
        $this->target->get('UnknownApi');
    }

    /**
     * @test
     */
    public function shouldGetEmptyArrayWhenGetApiListFirst()
    {
        // Act
        $actual = $this->target->all();

        // Assert
        $this->assertEquals([], $actual);
    }

    /**
     * @test
     */
    public function shouldGetOneApiListWhenAfterSetOneApiList()
    {
        // Arrange
        $exceptedApiName = 'some-api';
        $exceptedCount = 1;

        // Act
        $this->target->set($exceptedApiName, new Api('GET', $exceptedApiName));
        $actualApiList = $this->target->all();

        // Assert
        $this->assertArrayHasKey($exceptedApiName, $actualApiList);
        $this->assertCount($exceptedCount, $actualApiList);
    }
}

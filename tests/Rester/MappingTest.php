<?php

namespace Tests\Rester;

use Corp104\Rester\Api\Path;
use Corp104\Rester\Exceptions\ApiNotFoundException;
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
}

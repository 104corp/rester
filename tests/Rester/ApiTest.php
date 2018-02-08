<?php

namespace Tests\Rester;

use Corp104\Rester\Api;
use Corp104\Rester\Exception\InvalidArgumentException;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * @test
     */
    public function shouldThrowInvalidArgumentExceptionWhenPassUnknownHttpMethod()
    {
        $this->expectException(InvalidArgumentException::class);

        new Api('Unknown', 'some-url');
    }

    /**
     * @test
     */
    public function shouldGetNormalApiWhenCallBuildWithNormalApiAndNormalMode()
    {
        $target = new Api('GET', '/foo');

        $this->assertSame('GET', $target->getMethod());
        $this->assertSame('/foo', $target->getPath());
    }
}

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

    /**
     * @test
     */
    public function shouldBindPathOk()
    {
        $target = new Api('GET', '/foo/{bar}');

        $binding = [
            'bar' => 'some',
        ];

        $this->assertSame('/foo/some', $target->getPath($binding));
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenBindingNotComplete()
    {
        $this->expectException(InvalidArgumentException::class);

        $target = new Api('GET', '/foo/{bar}/{baz}');

        $binding = [
            'bar' => 'some',
        ];

        $target->getPath($binding);
    }
}

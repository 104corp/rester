<?php

namespace Tests\Rester;

use Corp104\Rester\Api\Api;
use Corp104\Rester\Exceptions\InvalidArgumentException;
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
    public function shouldBindPathOkWithoutBinding()
    {
        $target = new Api('GET', '/foo');

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

    /**
     * @test
     */
    public function shouldThrowExceptionWhenBindingNotCompleteWithEmptyBinding()
    {
        $this->expectException(InvalidArgumentException::class);

        $target = new Api('GET', '/foo/{bar}');

        $target->getPath();
    }

    /**
     * @test
     * @dataProvider availableMethod
     */
    public function shouldSendCorrectRequestWhenUsingApiRequest($method)
    {
        $baseUrl = 'http://127.0.0.1';
        $exceptedUrl = $baseUrl . '/foo';

        $target = new Api($method, '/foo');
        $request = $target->createRequest(
            $baseUrl
        );

        $this->assertEquals($method, $request->getMethod());
        $this->assertContains($exceptedUrl, (string)$request->getUri());
    }

    public function availableMethod(): array
    {
        return [
            ['GET'],
            ['POST'],
            ['PUT'],
            ['DELETE'],
        ];
    }
}

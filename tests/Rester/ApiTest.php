<?php

namespace Tests\Rester;

use Corp104\Rester\Api\Api;
use Corp104\Rester\Api\ApiAbstract;
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
    }

    /**
     * @test
     */
    public function shouldBindPathOkWithoutBinding()
    {
        $this->assertSame('/foo', ApiAbstract::buildPath('/foo'));
    }

    /**
     * @test
     */
    public function shouldBindPathOk()
    {
        $actual = ApiAbstract::buildPath('/foo/{bar}', [
            'bar' => 'some',
        ]);

        $this->assertSame('/foo/some', $actual);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenBindingNotComplete()
    {
        $this->expectException(InvalidArgumentException::class);

        $binding = [
            'bar' => 'some',
        ];

        ApiAbstract::buildPath('/foo/{bar}/{baz}', $binding);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenBindingNotCompleteWithEmptyBinding()
    {
        $this->expectException(InvalidArgumentException::class);

        ApiAbstract::buildPath('/foo/{bar}');
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

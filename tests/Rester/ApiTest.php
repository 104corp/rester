<?php

namespace Tests\Rester;

use Corp104\Rester\Api\Path;
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

        new Path('Unknown', 'some-url');
    }

    /**
     * @test
     */
    public function shouldGetNormalApiWhenCallBuildWithNormalApiAndNormalMode()
    {
        $target = new Path('GET', '/foo');

        $this->assertSame('GET', $target->getMethod());
    }

    /**
     * @test
     */
    public function shouldBindPathOkWithoutBinding()
    {
        $this->assertSame('/foo', Api::buildPath('/foo'));
    }

    /**
     * @test
     */
    public function shouldBindPathOk()
    {
        $actual = Api::buildPath('/foo/{bar}', [
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

        Api::buildPath('/foo/{bar}/{baz}', $binding);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenBindingNotCompleteWithEmptyBinding()
    {
        $this->expectException(InvalidArgumentException::class);

        Api::buildPath('/foo/{bar}');
    }

    /**
     * @test
     * @dataProvider availableMethod
     */
    public function shouldSendCorrectRequestWhenUsingApiRequest($method)
    {
        $baseUrl = 'http://127.0.0.1';
        $exceptedUrl = $baseUrl . '/foo';

        $target = new Path($method, '/foo');
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

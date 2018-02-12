<?php

namespace Tests\Rester\Api;

use Corp104\Rester\Api\Path;
use Corp104\Rester\Exceptions\InvalidArgumentException;
use Tests\TestCase;

class PathTest extends TestCase
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

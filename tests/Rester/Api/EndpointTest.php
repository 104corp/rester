<?php

namespace Tests\Rester\Api;

use Corp104\Rester\Api\Endpoint;
use Corp104\Rester\Exceptions\InvalidArgumentException;
use Tests\TestCase;

class EndpointTest extends TestCase
{
    /**
     * @test
     */
    public function shouldThrowInvalidArgumentExceptionWhenPassUnknownHttpMethod()
    {
        $this->expectException(InvalidArgumentException::class);

        new Endpoint('Unknown', 'http://localhost/some-url');
    }

    /**
     * @test
     */
    public function shouldGetNormalApiWhenCallBuildWithNormalApiAndNormalMode()
    {
        $target = new Endpoint('GET', 'http://localhost/foo');

        $this->assertSame('GET', $target->getMethod());
    }

    /**
     * @test
     * @dataProvider availableMethod
     */
    public function shouldSendCorrectRequestWhenUsingEndpointRequest($method)
    {
        $endpoint = 'http://127.0.0.1/foo/{bar}';
        $binding = ['bar' => 'some'];

        $exceptedUrl = 'http://127.0.0.1/foo/some';

        $target = new Endpoint($method, $endpoint);

        $actual = $target->createRequest($binding);

        $this->assertEquals($method, $actual->getMethod());
        $this->assertContains($exceptedUrl, (string)$actual->getUri());
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

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
     */
    public function shouldSendBodyWhenUsingPostRequest()
    {
        $endpoint = 'http://127.0.0.1/foo';

        $target = new Endpoint('POST', $endpoint);

        $actual = $target->createRequest([], [], ['body' => 'some']);

        $this->assertSame('{"body":"some"}', (string)$actual->getBody());
        $this->assertSame('application/json; charset=UTF-8', (string)$actual->getHeaderLine('Content-type'));
        $this->assertSame('100-continue', (string)$actual->getHeaderLine('Expect'));
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

        $actual = $target->createRequest($binding, ['q' => 'some']);

        $this->assertEquals($method, $actual->getMethod());
        $this->assertContains($exceptedUrl, (string)$actual->getUri());
        $this->assertContains('q=some', (string)$actual->getUri());
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

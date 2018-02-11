<?php

namespace Tests\Rester;

use ArrayObject;
use Corp104\Rester\Api;
use Corp104\Rester\Exception\InvalidArgumentException;
use Corp104\Rester\Http\Factory;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Uri;
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
        $history = new ArrayObject();
        $httpClient = $this->createHttpClient(new Response(), $history);

        $baseUrl = 'http://127.0.0.1';
        $exceptedUrl = $baseUrl . '/foo';

        $target = new Api($method, '/foo');
        $request = $target->createRequest(
            new Factory($httpClient),
            $baseUrl
        );
        $request->sendRequest();

        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $history[0]['request'];

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

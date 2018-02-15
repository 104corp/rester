<?php

namespace Tests\Rester;

use ArrayObject;
use Corp104\Rester\Api\Endpoint;
use Corp104\Rester\Api\Path;
use Corp104\Rester\Exceptions\InvalidArgumentException;
use Corp104\Rester\ResterClient;
use Corp104\Rester\ResterRequest;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Tests\Fixture\TestResterClient;
use Tests\TestCase;

/**
 * Basic test
 */
class ResterClientBasicTest extends TestCase
{
    /**
     * @var TestResterClient
     */
    protected $target;

    protected function setUp()
    {
        parent::setUp();

        $this->target = new TestResterClient();
    }

    protected function tearDown()
    {
        $this->target = null;

        parent::tearDown();
    }

    /**
     * @test
     */
    public function shouldThrowInvalidArgumentExceptionWhenFirstParamsIsNotArray()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->target->getFoo('NotArray');
    }

    /**
     * @test
     */
    public function shouldThrowInvalidArgumentExceptionWhenSecondParamsIsNotArray()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->target->getFoo([], 'NotArray');
    }

    /**
     * @test
     */
    public function shouldThrowInvalidArgumentExceptionWhenThirdParamsIsNotArray()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->target->getFoo([], [], 'NotArray');
    }

    /**
     * @test
     */
    public function shouldThrowClientExceptionWhenServerReturn401()
    {
        $history = new ArrayObject();

        $httpClient = $this->createHttpClient(new Response(401), $history);
        $this->target->setHttpClient($httpClient);
        $this->expectException(ClientException::class);

        $this->target->getFoo();
    }

    /**
     * @test
     */
    public function shouldThrowApiNotFoundExceptionWhenServerReturn404()
    {
        $history = new ArrayObject();

        $httpClient = $this->createHttpClient(new Response(404), $history);
        $this->target->setHttpClient($httpClient);
        $this->expectException(ClientException::class);

        $this->target->getFoo();
    }

    /**
     * @test
     */
    public function shouldThrowApiNotFoundExceptionWhenServerReturn405()
    {
        $history = new ArrayObject();

        $httpClient = $this->createHttpClient(new Response(405), $history);
        $this->target->setHttpClient($httpClient);
        $this->expectException(ClientException::class);

        $this->target->postFoo();
    }

    /**
     * @test
     */
    public function shouldThrowServerExceptionWhenServerReturn500()
    {
        $history = new ArrayObject();

        $httpClient = $this->createHttpClient(new Response(500), $history);
        $this->target->setHttpClient($httpClient);
        $this->expectException(ServerException::class);

        $this->target->getFoo();
    }

    /**
     * @test
     */
    public function shouldRemoveSlashWhenBaseUrlHasSlashAtTail()
    {
        $target = new ResterClient('http://some-endpoint/');
        $this->assertSame('http://some-endpoint', $target->getBaseUrl());

        $target = new ResterClient('http://some-endpoint');
        $this->assertSame('http://some-endpoint', $target->getBaseUrl());
    }

    /**
     * @test
     */
    public function shouldNotEffectToEndpointApiWhenBaseUrlIsDifferent()
    {
        $exceptedEndpoint = 'http://some-endpoint/some';

        $mapping = $this->target->getMapping();
        $mapping->set('someEndpoint', new Endpoint('GET', $exceptedEndpoint));

        $history = new ArrayObject();
        $httpClient = $this->createHttpClient(new Response(), $history);

        $target = new ResterClient('http://some-endpoint/');
        $target->setMapping($mapping);
        $target->setHttpClient($httpClient);

        $target->someEndpoint();

        /** @var RequestInterface $request */
        $request = $history[0]['request'];

        $this->assertSame($exceptedEndpoint, (string)$request->getUri());
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallEndpointWithResterRequest()
    {
        $endpoint = 'http://some-endpoint/{foo}';
        $binding = ['foo' => 'some'];
        $exceptedEndpoint = 'http://some-endpoint/some';

        $mapping = $this->target->getMapping();
        $mapping->set('someEndpoint', new Endpoint('GET', $endpoint));

        $history = new ArrayObject();
        $httpClient = $this->createHttpClient(new Response(), $history);

        $target = new ResterClient('http://some-endpoint/');
        $target->setMapping($mapping);
        $target->setHttpClient($httpClient);

        $target->someEndpoint(ResterRequest::create($binding));

        /** @var RequestInterface $request */
        $request = $history[0]['request'];

        $this->assertSame($exceptedEndpoint, (string)$request->getUri());
    }

    /**
     * @test
     */
    public function shouldCallAnotherApiWhenApiUrlIsSetAnother()
    {
        $history = new ArrayObject();

        $httpClient = $this->createHttpClient(new Response(), $history);
        $this->target->setHttpClient($httpClient);

        $this->target->getMapping()->set('postFoo', new Path('POST', '/bar'));

        $this->target->postFoo();

        /** @var RequestInterface $request */
        $request = $history[0]['request'];

        $this->assertContains('/bar', (string)$request->getUri());
        $this->assertNotContains('/foo', (string)$request->getUri());
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallHasApi()
    {
        $this->assertFalse($this->target->hasApi('newOne'));

        $this->target->getMapping()->set('newOne', new Path('GET', '/foo'));

        $this->assertTrue($this->target->hasApi('newOne'));
    }

    /**
     * @test
     */
    public function shouldCallAsyncWhenApiIsAsync()
    {
        $history = new ArrayObject();

        $httpClient = $this->createHttpClient(new Response(), $history);
        $this->target->setHttpClient($httpClient);

        $api = new Path('POST', '/bar');
        $api->asynchronous();

        $this->target->getMapping()->set('postFoo', $api);

        $actual = $this->target->postFoo();

        $this->assertInstanceOf(PromiseInterface::class, $actual);
    }
}

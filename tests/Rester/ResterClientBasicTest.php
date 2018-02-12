<?php

namespace Tests\Rester;

use ArrayObject;
use Corp104\Rester\Api\Endpoint;
use Corp104\Rester\Api\Path;
use Corp104\Rester\Exceptions\InvalidArgumentException;
use Corp104\Rester\ResterClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
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

        $mapping = $this->target->getRestMapping();
        $mapping->set('someEndpoint', new Endpoint('GET', $exceptedEndpoint));

        $history = new ArrayObject();

        $responseJson = '[]';
        $httpClient = $this->createHttpClient(new Response(200, [], $responseJson), $history);

        $target = new ResterClient('http://some-endpoint/');
        $target->setRestMapping($mapping);
        $target->setHttpClient($httpClient);

        $target->someEndpoint();

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

        $responseJson = '[]';
        $httpClient = $this->createHttpClient(new Response(200, [], $responseJson), $history);
        $this->target->setHttpClient($httpClient);

        $this->target->getRestMapping()->set('postFoo', new Path('POST', '/bar'));

        $this->target->postFoo();

        /** @var RequestInterface $request */
        $request = $history[0]['request'];

        $this->assertContains('/bar', (string)$request->getUri());
        $this->assertNotContains('/foo', (string)$request->getUri());
    }
}

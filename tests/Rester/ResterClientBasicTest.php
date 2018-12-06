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
use GuzzleHttp\Psr7\Request;
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
        $this->setExpectedException(InvalidArgumentException::class);

        $this->target->getFoo('NotArray');
    }

    /**
     * @test
     */
    public function shouldThrowInvalidArgumentExceptionWhenSecondParamsIsNotArray()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $this->target->getFoo([], 'NotArray');
    }

    /**
     * @test
     */
    public function shouldThrowInvalidArgumentExceptionWhenThirdParamsIsNotArray()
    {
        $this->setExpectedException(InvalidArgumentException::class);

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
        $this->setExpectedException(ClientException::class);

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
        $this->setExpectedException(ClientException::class);

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
        $this->setExpectedException(ClientException::class);

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
        $this->setExpectedException(ServerException::class);

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
    public function shouldReturnFalseWhenCallHasApiAfterRemoveApi()
    {
        $this->assertTrue($this->target->hasApi('getFoo'));

        $this->target->getMapping()->forget('getFoo');

        $this->assertFalse($this->target->hasApi('getFoo'));
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallHasApiAfterCallOnly()
    {
        $this->assertTrue($this->target->hasApi('getFoo'));
        $this->assertTrue($this->target->hasApi('postFoo'));

        $this->target->getMapping()->only('getFoo');

        $this->assertTrue($this->target->hasApi('getFoo'));
        $this->assertFalse($this->target->hasApi('postFoo'));
    }

    /**
     * @test
     */
    public function shouldWithHeaderWhenCallApiWithCustomHeader()
    {
        $history = new ArrayObject();

        $httpClient = $this->createHttpClient(new Response(), $history);
        $this->target->setHttpClient($httpClient);

        $api = Path::create('POST', '/bar');
        $api->setHeader('test_string', 'string');
        $api->setHeader('test_array', ['arr1', 'arr2']);

        $this->target->getMapping()->set('postFoo', $api);

        $this->target->postFoo();

        /** @var Request $request */
        $request = $history[0]['request'];

        $this->assertSame(['string'], $request->getHeader('test_string'));
        $this->assertSame('string', $request->getHeaderLine('test_string'));
        $this->assertSame(['arr1', 'arr2'], $request->getHeader('test_array'));
        $this->assertSame('arr1, arr2', $request->getHeaderLine('test_array'));
    }

    /**
     * @test
     */
    public function shouldSendClientHeaderWhenClientAndApiSetTheSameHeader()
    {
        $history = new ArrayObject();

        $httpClient = $this->createHttpClient(new Response(), $history);
        $this->target->setHttpClient($httpClient);

        $api = Path::create('POST', '/bar');
        $api->setHeader('test', 'from_api');

        $this->target->getMapping()->set('postFoo', $api);

        $options = $this->target->getHttpOptions();
        $options['headers']['test'] = 'from_options';
        $this->target->setHttpOptions($options);

        $this->target->postFoo();

        /** @var Request $request */
        $request = $history[0]['request'];

        $this->assertSame('from_options', $request->getHeaderLine('test'));
    }

    /**
     * @test
     */
    public function shouldUsingNewBaseUrlWhenSetNewBaseUrl()
    {
        $excepted = 'new-base-url';

        $history = new ArrayObject();

        $httpClient = $this->createHttpClient(new Response(), $history);
        $this->target->setHttpClient($httpClient);

        $this->target->setBaseUrl($excepted);

        $this->assertSame($excepted, $this->target->getMapping()->getBaseUrl());

        $this->target->postFoo();

        /** @var Request $request */
        $request = $history[0]['request'];

        $this->assertContains($excepted, (string)$request->getUri());
    }
}

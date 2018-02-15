<?php

namespace Tests\Rester;

use ArrayObject;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Tests\Fixture\TestResterClientAsync;
use Tests\TestCase;

/**
 * Basic test
 */
class ResterClientAsyncTest extends TestCase
{
    /**
     * @var TestResterClientAsync
     */
    protected $target;

    protected function setUp()
    {
        parent::setUp();

        $this->target = new TestResterClientAsync();
    }

    protected function tearDown()
    {
        $this->target = null;

        parent::tearDown();
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallAsyncAndWaitResponse()
    {
        $history = new ArrayObject();
        $httpClient = $this->createHttpClient(new Response(), $history);

        $this->target->setHttpClient($httpClient);

        /** @var PromiseInterface $promise */
        $promise = $this->target->callAsync('getFoo');

        $this->assertInstanceOf(PromiseInterface::class, $promise);

        /** @var ResponseInterface $response */
        $response = $promise->wait();

        /** @var RequestInterface $request */
        $request = $history[0]['request'];

        $this->assertContains('/foo', (string)$request->getUri());
        $this->assertSame(200, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallMagicMethodUsingAsync()
    {
        $history = new ArrayObject();
        $httpClient = $this->createHttpClient(new Response(200), $history);

        $this->target->setHttpClient($httpClient);

        $actual = $this->target->getFoo();

        $this->assertInstanceOf(PromiseInterface::class, $actual);
    }
}

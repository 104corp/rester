<?php

namespace Tests\Rester;

use ArrayObject;
use Corp104\Rester\ResterRequest;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Tests\Fixture\TestResterClient;
use Tests\TestCase;

/**
 * REST test
 */
class ResterClientTest extends TestCase
{
    /**
     * @var TestResterClient
     */
    protected $target;

    protected function setUp(): void
    {
        parent::setUp();

        $this->target = new TestResterClient();
    }

    protected function tearDown(): void
    {
        $this->target = null;

        parent::tearDown();
    }

    /**
     * @test
     */
    public function shouldSendCorrectMethodAndUrlAndParamsWhenGetSomeThing(): void
    {
        $history = new ArrayObject();
        $httpClient = $this->createHttpClient(new Response(), $history);

        $exceptedUrl = $this->target->getBaseUrl() . '/foo';

        $this->target->setHttpClient($httpClient);

        $this->target->getFoo();

        /** @var Request $request */
        $request = $history[0]['request'];

        $this->assertSame('GET', $request->getMethod());
        $this->assertStringContainsString($exceptedUrl, (string)$request->getUri());
    }

    /**
     * @test
     */
    public function shouldSendCorrectMethodAndUrlAndParamsWhenPostSomething(): void
    {
        $history = new ArrayObject();
        $httpClient = $this->createHttpClient(new Response(), $history);

        $id = 'some-id';
        $parsedBody = ['id' => $id];

        $exceptedUrl = $this->target->getBaseUrl() . '/foo';

        $this->target->setHttpClient($httpClient);

        $this->target->postFoo([], [], $parsedBody);

        /** @var Request $request */
        $request = $history[0]['request'];

        $this->assertSame('POST', $request->getMethod());
        $this->assertStringContainsString($exceptedUrl, (string)$request->getUri());
        $this->assertContains('application/json; charset=UTF-8', $request->getHeader('Content-type'));
        $this->assertSame('{"id":"' . $id . '"}', (string)$request->getBody());
    }

    /**
     * @test
     */
    public function shouldSendCorrectMethodAndUrlAndParamsWhenPostSomethingWithResterRequest(): void
    {
        $history = new ArrayObject();
        $httpClient = $this->createHttpClient(new Response(), $history);

        $id = 'some-id';
        $parsedBody = ['id' => $id];

        $exceptedUrl = $this->target->getBaseUrl() . '/foo';

        $this->target->setHttpClient($httpClient);

        $this->target->postFoo(
            ResterRequest::create()->setParsedBody($parsedBody)
        );

        /** @var Request $request */
        $request = $history[0]['request'];

        $this->assertSame('POST', $request->getMethod());
        $this->assertStringContainsString($exceptedUrl, (string)$request->getUri());
        $this->assertContains('application/json; charset=UTF-8', $request->getHeader('Content-type'));
        $this->assertSame('{"id":"' . $id . '"}', (string)$request->getBody());
    }

    /**
     * @test
     */
    public function shouldSendCorrectMethodAndUrlAndParamsWhenPutSomething(): void
    {
        $history = new ArrayObject();
        $httpClient = $this->createHttpClient(new Response(), $history);

        $id = 'some-id';
        $parsedBody = ['id' => $id];

        $exceptedUrl = $this->target->getBaseUrl() . '/foo';

        $this->target->setHttpClient($httpClient);

        $this->target->putFoo([], [], $parsedBody);

        /** @var Request $request */
        $request = $history[0]['request'];

        $this->assertSame('PUT', $request->getMethod());
        $this->assertStringContainsString($exceptedUrl, (string)$request->getUri());
        $this->assertContains('application/json; charset=UTF-8', $request->getHeader('Content-type'));
        $this->assertSame('{"id":"' . $id . '"}', (string)$request->getBody());
    }

    /**
     * @test
     */
    public function shouldSendCorrectMethodAndUrlAndParamsWhenPutSomethingWithResterRequest(): void
    {
        $history = new ArrayObject();
        $httpClient = $this->createHttpClient(new Response(), $history);

        $id = 'some-id';
        $parsedBody = ['id' => $id];

        $exceptedUrl = $this->target->getBaseUrl() . '/foo';

        $this->target->setHttpClient($httpClient);

        $this->target->putFoo(
            ResterRequest::create()->setParsedBody($parsedBody)
        );

        /** @var Request $request */
        $request = $history[0]['request'];

        $this->assertSame('PUT', $request->getMethod());
        $this->assertStringContainsString($exceptedUrl, (string)$request->getUri());
        $this->assertContains('application/json; charset=UTF-8', $request->getHeader('Content-type'));
        $this->assertSame('{"id":"' . $id . '"}', (string)$request->getBody());
    }

    /**
     * @test
     */
    public function shouldSendCorrectMethodAndUrlAndParamsWhenDeleteSomething(): void
    {
        $history = new ArrayObject();
        $httpClient = $this->createHttpClient(new Response(), $history);

        $exceptedUrl = $this->target->getBaseUrl() . '/foo';

        $this->target->setHttpClient($httpClient);
        $this->target->deleteFoo();

        /** @var Request $request */
        $request = $history[0]['request'];

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertStringContainsString($exceptedUrl, (string)$request->getUri());
    }
}

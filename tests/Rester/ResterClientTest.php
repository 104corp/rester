<?php

namespace Tests\Rester;

use ArrayObject;
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
    public function shouldSendCorrectMethodAndUrlAndParamsWhenGetSomeThing()
    {
        $history = new ArrayObject();
        $httpClient = $this->createHttpClient(new Response(), $history);

        $exceptedUrl = $this->target->getBaseUrl() . '/foo';

        $this->target->setHttpClient($httpClient);

        $this->target->getFoo();

        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $history[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertContains($exceptedUrl, (string)$request->getUri());
    }

    /**
     * @test
     */
    public function shouldSendCorrectMethodAndUrlAndParamsWhenPostSomeThing()
    {
        $history = new ArrayObject();
        $httpClient = $this->createHttpClient(new Response(), $history);

        $id = 'some-id';
        $parsedBody = ['id' => $id];

        $exceptedUrl = $this->target->getBaseUrl() . '/foo';

        $this->target->setHttpClient($httpClient);

        $this->target->postFoo([], [], $parsedBody);

        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $history[0]['request'];

        $this->assertEquals('POST', $request->getMethod());
        $this->assertContains($exceptedUrl, (string)$request->getUri());
        $this->assertContains('application/json; charset=UTF-8', $request->getHeader('Content-type'));
        $this->assertEquals('{"id":"' . $id . '"}', (string)$request->getBody());
    }

    /**
     * @test
     */
    public function shouldSendCorrectMethodAndUrlAndParamsWhenPutSomeThing()
    {
        $history = new ArrayObject();
        $httpClient = $this->createHttpClient(new Response(), $history);

        $id = 'some-id';
        $parsedBody = ['id' => $id];

        $exceptedUrl = $this->target->getBaseUrl() . '/foo';

        $this->target->setHttpClient($httpClient);

        $this->target->putFoo([], [], $parsedBody);

        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $history[0]['request'];

        $this->assertEquals('PUT', $request->getMethod());
        $this->assertContains($exceptedUrl, (string)$request->getUri());
        $this->assertContains('application/json; charset=UTF-8', $request->getHeader('Content-type'));
        $this->assertEquals('{"id":"' . $id . '"}', (string)$request->getBody());
    }

    /**
     * @test
     */
    public function shouldSendCorrectMethodAndUrlAndParamsWhenDeleteSomeThing()
    {
        $history = new ArrayObject();
        $httpClient = $this->createHttpClient(new Response(), $history);

        $exceptedUrl = $this->target->getBaseUrl() . '/foo';

        $this->target->setHttpClient($httpClient);
        $this->target->deleteFoo();

        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $history[0]['request'];

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertContains($exceptedUrl, (string)$request->getUri());
    }
}

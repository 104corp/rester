<?php

namespace Tests\Integration;

use ArrayObject;
use Corp104\Rester\ResterClient;
use Corp104\Rester\ResterRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Tests\Fixture\Server\Server;
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
    public function shouldBeOkWhenGetSomething()
    {
        $response = $this->target->getFoo();

        $this->assertSame(200, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldBeOkWhenPostSomething()
    {
        $response = $this->target->postFoo();

        $this->assertSame(200, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldBeOkWhenPutSomething()
    {
        $response = $this->target->putFoo();

        $this->assertSame(200, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldBeOkWhenDeleteSomething()
    {
        $response = $this->target->deleteFoo();

        $this->assertSame(200, $response->getStatusCode());
    }
}

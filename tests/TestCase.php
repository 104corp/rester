<?php

namespace Tests;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * Creates HTTP client.
     *
     * @param Response|Response[] $responses
     * @param array $history
     * @return HandlerStack
     */
    public function createHandlerStack($responses, $history = [])
    {
        if (!\is_array($responses)) {
            $responses = [$responses];
        }

        $handler = HandlerStack::create(new MockHandler($responses));
        $handler->push(Middleware::history($history));

        return $handler;
    }

    /**
     * Creates HTTP client.
     *
     * @param Response|Response[] $responses
     * @param array $history
     * @return HttpClient
     */
    public function createHttpClient($responses, $history = [])
    {
        $handler = $this->createHandlerStack($responses, $history);

        return new HttpClient([
            'handler' => $handler,
        ]);
    }
}

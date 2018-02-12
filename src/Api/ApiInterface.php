<?php

namespace Corp104\Rester\Api;

use Corp104\Rester\Exceptions\InvalidArgumentException;
use Corp104\Rester\Http\Factory;
use Corp104\Rester\Http\ResterRequestInterface;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

/**
 * Api Class
 */
interface ApiInterface
{
    /**
     * @param Factory $factory
     * @param string $baseUrl
     * @param array $binding
     * @return ResterRequestInterface
     * @throws InvalidArgumentException
     */
    public function createRequest(Factory $factory, string $baseUrl, array $binding = []): ResterRequestInterface;

    /**
     * @return string
     */
    public function getMethod(): string;

    /**
     * @param array $binding
     * @return string
     */
    public function getPath(array $binding = []): string;
}

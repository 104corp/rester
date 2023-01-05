<?php

declare(strict_types=1);

namespace Corp104\Rester\Api;

use Corp104\Rester\Exceptions\InvalidArgumentException;
use Corp104\Rester\Support\BaseUrlAwareInterface;
use Corp104\Rester\Support\BaseUrlAwareTrait;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Utils;

/**
 * Api Class
 */
class Path extends Api implements BaseUrlAwareInterface
{
    use BaseUrlAwareTrait;

    /**
     * API constructor.
     *
     * @param string $method
     * @param string $path
     * @throws InvalidArgumentException
     */
    public function __construct(string $method, string $path)
    {
        if ('/' !== $path[0]) {
            $path = '/' . $path;
        }

        parent::__construct($method, $path);
    }

    public function createRequest(array $binding = [], array $queryParams = [], array $parsedBody = []): Request
    {
        $headers = $this->getHeaders();
        $body = null;

        $uri = $this->baseUrl . $this->bindUri($binding);

        $uri = new Uri($uri);
        $uri = $uri->withQuery(static::buildQueryString($queryParams));

        if (!empty($parsedBody)) {
            // TODO: JSON only now, but it is not good
            $headers['Content-type'] = 'application/json; charset=UTF-8';
            $headers['Expect'] = '100-continue';

            $body = Utils::jsonEncode($parsedBody);
        }

        return new Request(
            $this->getMethod(),
            $uri,
            $headers,
            $body
        );
    }
}

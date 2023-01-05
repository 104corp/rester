<?php

declare(strict_types=1);

namespace Corp104\Rester\Api;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use JsonException;

use function json_encode;

/**
 * Endpoint Class
 */
class Endpoint extends Api
{
    /**
     * @throws JsonException
     */
    public function createRequest(array $binding = [], array $queryParams = [], array $parsedBody = []): Request
    {
        $headers = $this->getHeaders();
        $body = null;

        $uri = $this->bindUri($binding);

        $uri = new Uri($uri);
        $uri = $uri->withQuery(static::buildQueryString($queryParams));

        if (!empty($parsedBody)) {
            // TODO: JSON only now, but it is not good
            $headers['Content-type'] = 'application/json; charset=UTF-8';
            $headers['Expect'] = '100-continue';

            $body = json_encode($parsedBody, JSON_THROW_ON_ERROR);
        }

        return new Request(
            $this->getMethod(),
            $uri,
            $headers,
            $body
        );
    }
}

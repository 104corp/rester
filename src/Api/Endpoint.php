<?php

declare(strict_types=1);

namespace Corp104\Rester\Api;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Utils;

/**
 * Endpoint Class
 */
class Endpoint extends Api
{
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

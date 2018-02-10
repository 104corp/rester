<?php

namespace Corp104\Rester\Http;

use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

/**
 * Put request
 */
class Put extends ResterRequestAbstract
{
    public function sendRequest(
        $url,
        array $parsedBody = [],
        array $queryParams = [],
        array $guzzleOptions = []
    ): ResponseInterface {

        $guzzleOptions[RequestOptions::JSON] = $parsedBody;
        $guzzleOptions[RequestOptions::HEADERS]['Content-type'] = 'application/json; charset=UTF-8';
        $guzzleOptions[RequestOptions::HEADERS]['Expect'] = '100-continue';

        $url = $this->buildQueryString($url, $queryParams);

        return $this->httpClient->put($url, $guzzleOptions);
    }
}

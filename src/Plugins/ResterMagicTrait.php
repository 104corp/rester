<?php

namespace Corp104\Rester\Plugins;

use Corp104\Rester\Api\ApiInterface;
use Corp104\Rester\BaseUrlAwareTrait;
use Corp104\Rester\Exceptions\InvalidArgumentException;
use Corp104\Rester\ResterRequest;
use Corp104\Support\HttpClientAwareTrait;
use Exception;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * The Trait implement magic function __call()
 */
trait ResterMagicTrait
{
    /**
     * @param string $method
     * @param array $args
     * @return mixed
     * @throws Exception
     */
    public function __call($method, $args)
    {
        $binding = $args[0] ?? [];

        // Call directly when first parameter is instance of ResterRequest
        if ($binding instanceof ResterRequest) {
            return $this->callByResterRequest($method, $binding);
        }

        if (!\is_array($binding)) {
            throw new InvalidArgumentException('$binding must be an array');
        }

        $queryParams = $args[1] ?? [];

        if (!\is_array($queryParams)) {
            throw new InvalidArgumentException('$query must be an array');
        }

        $parsedBody = $args[2] ?? [];

        if (!\is_array($parsedBody)) {
            throw new InvalidArgumentException('$params must be an array');
        }

        return $this->callBySynchronousStatus($method, $binding, $queryParams, $parsedBody);
    }

    /**
     * @param string $name
     * @param ResterRequest $resterRequest
     * @return mixed
     * @throws Exception
     */
    protected function callByResterRequest(string $name, ResterRequest $resterRequest)
    {
        $binding = $resterRequest->getBinding();
        $queryParams = $resterRequest->getQueryParams();
        $parsedBody = $resterRequest->getParsedBody();

        return $this->callBySynchronousStatus($name, $binding, $queryParams, $parsedBody);
    }

    /**
     * @param string $name
     * @param array $binding
     * @param array $queryParams
     * @param array $parsedBody
     * @return mixed
     */
    protected function callBySynchronousStatus($name, $binding, $queryParams, $parsedBody)
    {
        $api = $this->mapping->get($name);

        if ($this->isAsynchronousCall($api)) {
            return $this->callAsync($name, $binding, $queryParams, $parsedBody);
        }

        return $this->call($name, $binding, $queryParams, $parsedBody);
    }
}

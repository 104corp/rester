<?php

declare(strict_types=1);

namespace Corp104\Rester\Plugins;

use Corp104\Rester\Exceptions\InvalidArgumentException;
use Corp104\Rester\ResterRequest;
use Exception;

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
        $binding = isset($args[0]) ? $args[0] : [];

        // Call directly when first parameter is instance of ResterRequest
        if ($binding instanceof ResterRequest) {
            return $this->callByResterRequest($method, $binding);
        }

        if (!\is_array($binding)) {
            throw new InvalidArgumentException('$binding must be an array');
        }

        $queryParams = isset($args[1]) ? $args[1] : [];

        if (!\is_array($queryParams)) {
            throw new InvalidArgumentException('$query must be an array');
        }

        $parsedBody = isset($args[2]) ? $args[2] : [];

        if (!\is_array($parsedBody)) {
            throw new InvalidArgumentException('$params must be an array');
        }

        return $this->call($method, $binding, $queryParams, $parsedBody);
    }

    /**
     * @param string $name
     * @param ResterRequest $resterRequest
     * @return mixed
     * @throws Exception
     */
    protected function callByResterRequest($name, ResterRequest $resterRequest)
    {
        $binding = $resterRequest->getBinding();
        $queryParams = $resterRequest->getQueryParams();
        $parsedBody = $resterRequest->getParsedBody();

        return $this->call($name, $binding, $queryParams, $parsedBody);
    }
}

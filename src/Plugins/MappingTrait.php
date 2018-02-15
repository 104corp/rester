<?php

namespace Corp104\Rester\Plugins;

use Corp104\Rester\Exceptions\ApiNotFoundException;
use Corp104\Rester\MappingAwareTrait;
use Psr\Http\Message\RequestInterface;

/**
 * Mapping trait plugin
 */
trait MappingTrait
{
    use MappingAwareTrait;

    /**
     * @param string $name
     * @param array $binding
     * @param array $queryParams
     * @param array $parsedBody
     * @return RequestInterface
     * @throws ApiNotFoundException
     */
    protected function createRequest($name, $binding, $queryParams, $parsedBody): RequestInterface
    {
        $api = $this->restMapping->get($name);

        return $api->createRequest($binding, $queryParams, $parsedBody);
    }
}

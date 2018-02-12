<?php

namespace Corp104\Rester;

use Corp104\Rester\Api\Api;
use Corp104\Rester\Exceptions\ApiNotFoundException;

/**
 * REST API mapping collection
 */
class Mapping implements BaseUrlAwareInterface
{
    use BaseUrlAwareTrait;

    /**
     * @var Api[]
     */
    protected $list = [];

    /**
     * @return Api[]
     */
    public function all(): array
    {
        return $this->list;
    }

    /**
     * @param string $api
     * @return Api
     * @throws ApiNotFoundException
     */
    public function get($api): Api
    {
        if (!isset($this->list[$api])) {
            throw new ApiNotFoundException("Invalid API: {$api}");
        }

        return $this->list[$api];
    }

    /**
     * @param string $name
     * @param Api $api
     */
    public function set($name, Api $api)
    {
        if ($api instanceof BaseUrlAwareInterface) {
            $api->setBaseUrl($this->baseUrl);
        }

        $this->list[$name] = $api;
    }
}

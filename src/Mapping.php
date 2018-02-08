<?php

namespace Corp104\Rester;

use Corp104\Rester\Exception\ApiNotFoundException;

/**
 * REST API mapping collection
 */
class Mapping
{
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
        $this->list[$name] = $api;
    }
}

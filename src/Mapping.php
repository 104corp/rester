<?php

namespace Corp104\Rester;

use Corp104\Rester\Api\Path;
use Corp104\Rester\Exceptions\ApiNotFoundException;

/**
 * REST API mapping collection
 */
class Mapping
{
    /**
     * @var Path[]
     */
    protected $list = [];

    /**
     * @return Path[]
     */
    public function all(): array
    {
        return $this->list;
    }

    /**
     * @param string $api
     * @return Path
     * @throws ApiNotFoundException
     */
    public function get($api): Path
    {
        if (!isset($this->list[$api])) {
            throw new ApiNotFoundException("Invalid API: {$api}");
        }

        return $this->list[$api];
    }

    /**
     * @param string $name
     * @param Path $api
     */
    public function set($name, Path $api)
    {
        $this->list[$name] = $api;
    }
}

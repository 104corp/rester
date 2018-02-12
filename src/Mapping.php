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
     * @param Api[] $mapping
     */
    public function __construct(array $mapping = [])
    {
        $this->init($mapping);
    }

    /**
     * @return Api[]
     */
    public function all(): array
    {
        return $this->list;
    }

    /**
     * @param string $name
     * @return Api
     * @throws ApiNotFoundException
     */
    public function get($name): Api
    {
        $api = $this->resolve($name);

        if ($api instanceof BaseUrlAwareInterface) {
            $api->setBaseUrl($this->baseUrl);
        }

        return $api;
    }

    /**
     * Initial mapping object
     *
     * @param Api[] $mapping
     */
    public function init(array $mapping)
    {
        foreach ($mapping as $name => $api) {
            $this->set($name, $api);
        }
    }

    /**
     * @param string $name
     * @param Api $api
     */
    public function set($name, Api $api)
    {
        $this->list[$name] = $api;
    }

    /**
     * @param string $name
     * @return Api
     * @throws ApiNotFoundException
     */
    protected function resolve($name): Api
    {
        if (!isset($this->list[$name])) {
            throw new ApiNotFoundException("Invalid API: {$name}");
        }

        return $this->list[$name];
    }
}

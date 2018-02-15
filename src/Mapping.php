<?php

namespace Corp104\Rester;

use Corp104\Rester\Api\Api;
use Corp104\Rester\Api\ApiInterface;
use Corp104\Rester\Exceptions\ApiNotFoundException;

/**
 * REST API mapping collection
 */
class Mapping implements BaseUrlAwareInterface, SynchronousAwareInterface
{
    use BaseUrlAwareTrait;
    use SynchronousNullTrait;

    /**
     * @var ApiInterface[]
     */
    protected $list = [];

    /**
     * @param ApiInterface[] $mapping
     */
    public function __construct(array $mapping = [])
    {
        $this->init($mapping);
    }

    /**
     * @return ApiInterface[]
     */
    public function all(): array
    {
        return $this->list;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->list);
    }

    /**
     * @param string $name
     * @return ApiInterface
     * @throws ApiNotFoundException
     */
    public function get($name): ApiInterface
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
     * @param ApiInterface[] $mapping
     */
    public function init(array $mapping)
    {
        foreach ($mapping as $name => $api) {
            $this->set($name, $api);
        }
    }

    /**
     * @param string $name
     * @param ApiInterface $api
     */
    public function set($name, ApiInterface $api)
    {
        $this->list[$name] = $api;
    }

    /**
     * @param string $name
     * @return ApiInterface
     * @throws ApiNotFoundException
     */
    protected function resolve($name): ApiInterface
    {
        if (!isset($this->list[$name])) {
            throw new ApiNotFoundException("Invalid API: {$name}");
        }

        return $this->list[$name];
    }
}

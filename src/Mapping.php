<?php

declare(strict_types=1);

namespace Corp104\Rester;

use Corp104\Rester\Api\ApiInterface;
use Corp104\Rester\Exceptions\ApiNotFoundException;
use Corp104\Rester\Exceptions\InvalidArgumentException;
use Corp104\Rester\Support\BaseUrlAwareInterface;
use Corp104\Rester\Support\BaseUrlAwareTrait;

/**
 * REST API mapping collection
 */
class Mapping implements BaseUrlAwareInterface
{
    use BaseUrlAwareTrait;

    /**
     * @var array
     */
    protected $list = [];

    /**
     * @param array $mapping
     */
    public function __construct(array $mapping = [])
    {
        $this->init($mapping);
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->list;
    }

    /**
     * @param array|string $keys
     */
    public function forget($keys)
    {
        if (!is_array($keys)) {
            $keys = func_get_args();
        }

        foreach ($keys as $key) {
            unset($this->list[$key]);
        }
    }

    /**
     * @param string $name
     * @return ApiInterface
     * @throws ApiNotFoundException
     */
    public function get($name)
    {
        if (!isset($this->list[$name])) {
            throw new ApiNotFoundException("Invalid API: {$name}");
        }

        if (!($this->list[$name] instanceof ApiInterface)) {
            $this->list[$name] = $this->resolve($this->list[$name]);
        }

        return $this->list[$name];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has($name)
    {
        return array_key_exists($name, $this->list);
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
     * @param array|string $keys
     */
    public function only($keys)
    {
        if (!is_array($keys)) {
            $keys = func_get_args();
        }

        $this->list = array_intersect_key($this->list, array_flip((array)$keys));
    }

    /**
     * @param string $name
     * @param ApiInterface|array $api
     * @throws InvalidArgumentException
     */
    public function set($name, $api)
    {
        if ($api instanceof ApiInterface) {
            $this->setByInstance($name, $api);
            return;
        }

        if (\is_array($api)) {
            $this->setBySetting($name, $api);
            return;
        }

        throw new InvalidArgumentException('Parameter api must be ApiInterface|array');
    }

    /**
     * @param string $name
     * @param ApiInterface $api
     * @throws InvalidArgumentException
     */
    public function setByInstance($name, ApiInterface $api)
    {
        $this->list[$name] = $api;
    }

    /**
     * Array structure is [resolver(callable), parameter(array)]
     *
     * @param string $name
     * @param array $api
     * @throws InvalidArgumentException
     */
    public function setBySetting($name, array $api)
    {
        $api = array_values($api);

        if (2 !== count($api)) {
            throw new InvalidArgumentException('Api array count must be 2');
        }

        if (!\is_callable($api[0])) {
            throw new InvalidArgumentException('Api array[0] is not callable');
        }

        if (!\is_array($api[1])) {
            throw new InvalidArgumentException('Api array[1] is not array');
        }

        $this->list[$name] = $api;
    }

    /**
     * Set all API base url
     */
    protected function afterSetBaseUrl()
    {
        foreach ($this->list as $api) {
            $this->duplicateBaseUrlTo($api);
        }
    }

    /**
     * @param array $setting
     * @return ApiInterface
     * @throws ApiNotFoundException
     */
    protected function resolve(array $setting)
    {
        $callable = $setting[0];

        /** @var ApiInterface $api */
        $api = \call_user_func_array($callable, $setting[1]);

        $this->duplicateBaseUrlTo($api);

        return $api;
    }
}

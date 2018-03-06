<?php

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
     * @param string $name
     * @return bool
     */
    public function has($name)
    {
        return array_key_exists($name, $this->list);
    }

    /**
     * @param string $name
     * @return ApiInterface
     * @throws ApiNotFoundException
     */
    public function get($name)
    {
        return $this->resolve($name);
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

        $type = \gettype($api);

        if ('object' === $type) {
            $type = \get_class($api);
        }

        throw new InvalidArgumentException("Parameter api must be ApiInterface|array. Given is {$type}");
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
     * Array structure is [parameter(array), resolver(callable)]
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
     *
     * @param $baseUrl
     */
    protected function afterSetBaseUrl($baseUrl)
    {
        foreach ($this->list as $api) {
            $this->transferBaseUrlTo($api, $baseUrl);
        }
    }

    /**
     * @param string $name
     * @return ApiInterface
     * @throws ApiNotFoundException
     */
    protected function resolve($name)
    {
        if (!isset($this->list[$name])) {
            throw new ApiNotFoundException("Invalid API: {$name}");
        }

        if ($this->list[$name] instanceof ApiInterface) {
            return $this->list[$name];
        }

        return $this->resolveBySetting($name);
    }

    /**
     * @param string $name
     * @return ApiInterface
     * @throws ApiNotFoundException
     */
    protected function resolveBySetting($name)
    {
        $setting = $this->list[$name];
        $callable = $setting[0];

        /** @var ApiInterface $api */
        $api = \call_user_func_array($callable, $setting[1]);

        $this->list[$name] = $this->transferBaseUrlTo($api, $this->baseUrl);

        return $this->list[$name];
    }

    /**
     * @param mixed $api
     * @param string $baseUrl
     * @return mixed
     */
    protected function transferBaseUrlTo($api, $baseUrl)
    {
        if ($api instanceof BaseUrlAwareInterface) {
            $api->setBaseUrl($baseUrl);
        }

        return $api;
    }
}

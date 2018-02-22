<?php

namespace Corp104\Rester;

use Corp104\Rester\Exceptions\CollectionNotFoundException;

/**
 * API collection
 */
class Collection
{
    /**
     * @var ResterInterface[]
     */
    protected $mapping = [];

    /**
     * @param ResterInterface[] $mapping
     */
    public function __construct(array $mapping = [])
    {
        $this->init($mapping);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->mapping);
    }

    /**
     * @param string $name
     * @return ResterInterface
     * @throws CollectionNotFoundException
     */
    public function get(string $name): ResterInterface
    {
        return $this->resolve($name);
    }

    /**
     * Initial collection object
     *
     * @param ResterInterface[] $mapping
     */
    public function init(array $mapping)
    {
        foreach ($mapping as $name => $client) {
            $this->set($name, $client);
        }
    }

    /**
     * @param string $name
     * @param ResterInterface $client
     */
    public function set(string $name, ResterInterface $client)
    {
        $this->mapping[$name] = $client;
    }

    /**
     * @param string $name
     * @return ResterInterface
     * @throws CollectionNotFoundException
     */
    protected function resolve(string $name): ResterInterface
    {
        if (!isset($this->mapping[$name])) {
            throw new CollectionNotFoundException("Collection '{$name}' is not found");
        }

        return $this->mapping[$name];
    }
}

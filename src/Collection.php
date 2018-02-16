<?php

namespace Corp104\Rester;

use Corp104\Rester\Exceptions\CollectionNotFoundException;

/**
 * API collection
 */
class Collection implements SynchronousAwareInterface
{
    use SynchronousNullTrait;

    /**
     * @var ResterClientInterface[]
     */
    protected $mapping = [];

    /**
     * @param ResterClientInterface[] $mapping
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
     * @return ResterClientInterface
     * @throws CollectionNotFoundException
     */
    public function get(string $name): ResterClientInterface
    {
        return $this->resolve($name);
    }

    /**
     * Initial collection object
     *
     * @param ResterClientInterface[] $mapping
     */
    public function init(array $mapping)
    {
        foreach ($mapping as $name => $client) {
            $this->set($name, $client);
        }
    }

    /**
     * @param string $name
     * @param ResterClientInterface $client
     */
    public function set(string $name, ResterClientInterface $client)
    {
        $this->transferSynchronousStatusTo($client);

        $this->mapping[$name] = $client;
    }

    /**
     * @param string $name
     * @return ResterClientInterface
     * @throws CollectionNotFoundException
     */
    protected function resolve(string $name): ResterClientInterface
    {
        if (!isset($this->mapping[$name])) {
            throw new CollectionNotFoundException("Collection '{$name}' is not found");
        }

        return $this->mapping[$name];
    }
}

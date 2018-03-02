<?php

namespace Corp104\Rester\Support;

use Corp104\Rester\Mapping;

/**
 * Mapping Aware Trait
 */
trait MappingAwareTrait
{
    /**
     * @var Mapping
     */
    protected $mapping;

    public function hasApi($name)
    {
        return $this->mapping->has($name);
    }

    /**
     * @return Mapping
     */
    public function getMapping()
    {
        return $this->mapping;
    }

    /**
     * @param array $mapping
     * @param null|string $baseUrl
     */
    public function provisionMapping(array $mapping, $baseUrl = null)
    {
        $this->setMapping(
            new Mapping($mapping),
            $baseUrl
        );
    }

    /**
     * Sets the REST API Mapping.
     *
     * @param Mapping $mapping
     * @param null $baseUrl
     */
    public function setMapping(Mapping $mapping, $baseUrl = null)
    {
        if (null !== $baseUrl) {
            $mapping->setBaseUrl($baseUrl);
        } elseif (method_exists($this, 'getBaseUrl')) {
            $mapping->setBaseUrl($this->getBaseUrl());
        }

        $this->mapping = $mapping;
    }
}

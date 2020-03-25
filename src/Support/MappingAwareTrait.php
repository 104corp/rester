<?php

declare(strict_types=1);

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
     */
    public function provisionMapping(array $mapping)
    {
        $this->setMapping(new Mapping($mapping));
    }

    /**
     * Sets the REST API Mapping.
     *
     * @param Mapping $mapping
     */
    public function setMapping(Mapping $mapping)
    {
        if (method_exists($this, 'getBaseUrl')) {
            $mapping->setBaseUrl($this->getBaseUrl());
        }

        $this->mapping = $mapping;
    }
}

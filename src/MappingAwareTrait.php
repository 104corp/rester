<?php

namespace Corp104\Rester;

/**
 * Mapping Aware Trait
 */
trait MappingAwareTrait
{
    /**
     * @var Mapping
     */
    protected $mapping;

    public function hasApi($name): bool
    {
        return $this->mapping->has($name);
    }

    /**
     * @return Mapping
     */
    public function getMapping(): Mapping
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
     * @param Mapping $restMapping
     * @param null $baseUrl
     */
    public function setMapping(Mapping $restMapping, $baseUrl = null)
    {
        if (null !== $baseUrl) {
            $restMapping->setBaseUrl($baseUrl);
        } elseif (method_exists($this, 'getBaseUrl')) {
            $restMapping->setBaseUrl($this->getBaseUrl());
        }

        $this->mapping = $restMapping;
    }
}

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
    protected $restMapping;

    /**
     * @return Mapping
     */
    public function getRestMapping(): Mapping
    {
        return $this->restMapping;
    }

    /**
     * @param array $mapping
     * @param null|string $baseUrl
     */
    public function provisionRestMapping(array $mapping, $baseUrl = null)
    {
        $this->setRestMapping(
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
    public function setRestMapping(Mapping $restMapping, $baseUrl = null)
    {
        if (null !== $baseUrl) {
            $restMapping->setBaseUrl($baseUrl);
        } elseif (method_exists($this, 'getBaseUrl')) {
            $restMapping->setBaseUrl($this->getBaseUrl());
        }

        $this->restMapping = $restMapping;
    }
}

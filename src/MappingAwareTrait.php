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
     * Sets the REST API Mapping.
     *
     * @param Mapping $restMapping
     */
    public function setRestMapping(Mapping $restMapping)
    {
        $this->restMapping = $restMapping;
    }
}

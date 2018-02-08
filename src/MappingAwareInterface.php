<?php

namespace Corp104\Rester;

/**
 * Mapping Aware Interface
 */
interface MappingAwareInterface
{
    /**
     * Sets the REST API Mapping.
     *
     * @param Mapping $mapping
     */
    public function setRestMapping(Mapping $mapping);
}

<?php

declare(strict_types=1);

namespace Corp104\Rester\Support;

use Corp104\Rester\Mapping;

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
    public function setMapping(Mapping $mapping);
}

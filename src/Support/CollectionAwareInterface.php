<?php

declare(strict_types=1);

namespace Corp104\Rester\Support;

use Corp104\Rester\Collection;

/**
 * Collection Aware Interface
 */
interface CollectionAwareInterface
{
    /**
     * Sets the collection
     *
     * @param Collection $mapping
     */
    public function setCollection(Collection $mapping);
}

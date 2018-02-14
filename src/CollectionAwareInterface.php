<?php

namespace Corp104\Rester;

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

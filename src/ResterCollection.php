<?php

namespace Corp104\Rester;

use Corp104\Rester\Support\CollectionAwareTrait;
use Corp104\Rester\Plugins\CollectionTrait;
use Corp104\Rester\Support\CollectionAwareInterface;

/**
 * Collection base Class
 */
class ResterCollection implements CollectionAwareInterface, ResterInterface
{
    use CollectionTrait;

    /**
     * @param array $provisionCollection
     */
    public function __construct(array $provisionCollection = [])
    {
        $this->collection = new Collection($provisionCollection);
    }
}

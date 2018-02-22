<?php

namespace Corp104\Rester;

use Corp104\Rester\Plugins\CollectionTrait;
use Corp104\Rester\Support\CollectionAwareInterface;

/**
 * Rester Client + Rester Collection class
 */
class ResterMix extends ResterClient implements CollectionAwareInterface
{
    use CollectionTrait;

    /**
     * @param string|null $baseUrl
     * @param array $httpOptions
     * @param array $provisionCollection
     */
    public function __construct($baseUrl = null, array $httpOptions = [], array $provisionCollection = [])
    {
        parent::__construct($baseUrl, $httpOptions);

        $this->collection = new Collection($provisionCollection);
    }
}

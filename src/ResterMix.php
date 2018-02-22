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
}

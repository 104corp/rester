<?php

namespace Corp104\Rester;

use Corp104\Rester\CollectionAwareTrait;
use Corp104\Rester\Plugins\CollectionMagicTrait;

/**
 * Collection base Class
 */
class ResterCollection implements CollectionAwareInterface
{
    use CollectionMagicTrait;
}

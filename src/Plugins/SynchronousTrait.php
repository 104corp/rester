<?php

namespace Corp104\Rester\Plugins;

use Corp104\Rester\SynchronousAwareTrait;

/**
 * SynchronousTrait
 */
trait SynchronousTrait
{
    use SynchronousAwareTrait;

    protected $synchronous = true;
}

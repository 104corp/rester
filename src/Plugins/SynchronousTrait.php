<?php

namespace Corp104\Rester\Plugins;

use Corp104\Rester\Support\SynchronousAwareTrait;

/**
 * SynchronousTrait
 */
trait SynchronousTrait
{
    use SynchronousAwareTrait;

    protected $synchronous = true;
}

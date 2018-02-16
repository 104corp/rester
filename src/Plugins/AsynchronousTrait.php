<?php

namespace Corp104\Rester\Plugins;

use Corp104\Rester\Support\SynchronousAwareTrait;

/**
 * AsynchronousTrait
 */
trait AsynchronousTrait
{
    use SynchronousAwareTrait;

    protected $synchronous = false;
}

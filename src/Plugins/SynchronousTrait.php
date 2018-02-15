<?php

namespace Corp104\Rester\Plugins;

use Corp104\Rester\CollectionAwareTrait;
use Corp104\Rester\Exceptions\OperationDeniedException;
use Corp104\Rester\Exceptions\InvalidArgumentException;
use Corp104\Rester\ResterClientInterface;

/**
 * SynchronousTrait
 */
trait SynchronousTrait
{
    protected $synchronous = true;

    /**
     * @return bool
     */
    public function isAsynchronous(): bool
    {
        return !$this->isSynchronous();
    }

    /**
     * @return bool
     */
    public function isSynchronous(): bool
    {
        return $this->synchronous;
    }

    /**
     * @return static
     */
    public function asynchronous()
    {
        return $this->setSynchronous(false);
    }

    /**
     * @param bool $synchronous
     * @return static
     */
    public function setSynchronous(bool $synchronous)
    {
        $this->synchronous = $synchronous;
        return $this;
    }

    /**
     * @return static
     */
    public function synchronous()
    {
        return $this->setSynchronous(true);
    }
}

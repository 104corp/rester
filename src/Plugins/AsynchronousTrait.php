<?php

namespace Corp104\Rester\Plugins;

use Corp104\Rester\CollectionAwareTrait;
use Corp104\Rester\Exceptions\OperationDeniedException;
use Corp104\Rester\Exceptions\InvalidArgumentException;
use Corp104\Rester\ResterClientInterface;

/**
 * AsynchronousTrait
 */
trait AsynchronousTrait
{
    /**
     * @var bool
     */
    protected $asynchronous = true;

    /**
     * @return bool
     */
    public function isAsynchronous(): bool
    {
        return $this->asynchronous;
    }

    /**
     * @return bool
     */
    public function isSynchronous(): bool
    {
        return !$this->isAsynchronous();
    }

    /**
     * @return static
     */
    public function asynchronous()
    {
        return $this->setAsynchronous(true);
    }

    /**
     * @param bool $synchronous
     * @return static
     */
    public function setAsynchronous(bool $synchronous)
    {
        $this->asynchronous = $synchronous;
        return $this;
    }

    /**
     * @return static
     */
    public function synchronous()
    {
        return $this->setAsynchronous(false);
    }
}

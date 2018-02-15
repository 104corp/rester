<?php

namespace Corp104\Rester;

/**
 * SynchronousAwareTrait
 */
trait SynchronousAwareTrait
{
    /**
     * @return bool
     */
    public function isAsynchronous(): bool
    {
        return !$this->synchronous;
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

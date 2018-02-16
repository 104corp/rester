<?php

namespace Corp104\Rester;

/**
 * SynchronousAwareTrait
 */
trait SynchronousAwareTrait
{
    /**
     * @return static
     */
    public function asynchronous()
    {
        return $this->setSynchronous(false);
    }

    /**
     * @return bool|null
     */
    public function getSynchronous()
    {
        return $this->synchronous;
    }

    /**
     * @return bool|null
     */
    public function isAsynchronous()
    {
        if (null === $this->synchronous) {
            return null;
        }

        return !$this->synchronous;
    }

    /**
     * @return bool|null
     */
    public function isSynchronous()
    {
        if (null === $this->synchronous) {
            return null;
        }

        return $this->synchronous;
    }

    /**
     * @param bool|null $synchronous
     * @return static
     */
    public function setSynchronous($synchronous)
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

    /**
     * @param mixed $instance
     */
    public function transferSynchronousStatusTo($instance)
    {
        // Do nothing when $instance not implement SynchronousAwareInterface
        if (!$instance instanceof SynchronousAwareInterface) {
            return;
        }

        // Do nothing when Collection has no synchronous setting
        if (null === $this->synchronous) {
            return;
        }

        // Do nothing when $instance has synchronous setting
        if (null !== $instance->getSynchronous()) {
            return;
        }

        $instance->setSynchronous($this->synchronous);
    }
}

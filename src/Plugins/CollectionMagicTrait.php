<?php

namespace Corp104\Rester\Plugins;

use Corp104\Rester\CollectionAwareTrait;
use Corp104\Rester\Exceptions\OperationDeniedException;
use Corp104\Rester\Exceptions\InvalidArgumentException;
use Corp104\Rester\ResterClientInterface;

/**
 * Api Collection magic method Trait
 */
trait CollectionMagicTrait
{
    use CollectionAwareTrait;

    public function __get($name)
    {
        return $this->collection->get($name);
    }

    public function __set($name, $value)
    {
        if (!$value instanceof ResterClientInterface) {
            $type = \gettype($value);

            if ('object' === $type) {
                $type = \get_class($value);
            }

            throw new InvalidArgumentException("Property must be instance of ResterClientInterface. Given is {$type}");
        }

        $this->collection->set($name, $value);
    }

    public function __isset($name)
    {
        return $this->collection->has($name);
    }

    public function __unset($name)
    {
        throw new OperationDeniedException('Cannot unset ResterClient property');
    }
}

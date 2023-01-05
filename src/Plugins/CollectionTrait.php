<?php

declare(strict_types=1);

namespace Corp104\Rester\Plugins;

use Corp104\Rester\Exceptions\InvalidArgumentException;
use Corp104\Rester\Exceptions\OperationDeniedException;
use Corp104\Rester\ResterInterface;
use Corp104\Rester\Support\CollectionAwareTrait;

use function get_class;
use function gettype;

/**
 * Collection Trait which implement magic method
 */
trait CollectionTrait
{
    use CollectionAwareTrait;

    public function __get($name)
    {
        return $this->collection->get($name);
    }

    public function __set($name, $value)
    {
        if (!$value instanceof ResterInterface) {
            $type = gettype($value);

            if ('object' === $type) {
                $type = get_class($value);
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

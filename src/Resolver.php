<?php

declare(strict_types=1);

namespace Corp104\Rester;

use Corp104\Rester\Exceptions\InvalidResolverException;

/**
 * The Resolver abstract class
 */
abstract class Resolver
{
    public function __invoke()
    {
        if (!method_exists($this, 'resolve')) {
            $class = \get_class($this);
            throw new InvalidResolverException("Class '$class' does not have resolve method");
        }

        $args = \func_get_args();

        return \call_user_func_array([$this, 'resolve'], $args);
    }
}

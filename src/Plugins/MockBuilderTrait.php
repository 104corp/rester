<?php

declare(strict_types=1);

namespace Corp104\Rester\Plugins;

use Mockery;

/**
 * Client Mock Trait
 */
trait MockBuilderTrait
{
    /**
     * @param array $stubs
     * @param bool $makePartial
     * @return Mockery\Mock|static
     */
    public static function createMock(array $stubs = [], $makePartial = true)
    {
        $mock = Mockery::mock(static::class);

        if ($makePartial) {
            $mock = $mock->makePartial();
        }

        foreach ($stubs as $method => $stub) {
            $mock->shouldReceive($method)->andReturn($stub);
        }

        return $mock;
    }
}

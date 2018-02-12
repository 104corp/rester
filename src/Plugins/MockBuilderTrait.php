<?php

namespace Corp104\Rester\Plugins;

use Mockery;

/**
 * Client Mock Trait
 */
trait MockBuilderTrait
{
    /**
     * @param array $stubs
     * @return Mockery\Mock|static
     */
    public static function createMock(array $stubs = [])
    {
        $mock = Mockery::mock(static::class)->makePartial();

        foreach ($stubs as $method => $stub) {
            $mock->shouldReceive($method)->andReturn($stub);
        }

        return $mock;
    }
}

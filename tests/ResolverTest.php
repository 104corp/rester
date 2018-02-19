<?php

namespace Tests\Rester;

use Corp104\Rester\Exceptions\InvalidResolverException;
use Corp104\Rester\Resolver;
use Tests\TestCase;

class ResolverTest extends TestCase
{
    /**
     * @test
     */
    public function shouldThrowExceptionWhenNotImplementResolveMethod()
    {
        $this->expectException(InvalidResolverException::class);

        $actual = new class extends Resolver
        {
        };

        $actual();
    }
}

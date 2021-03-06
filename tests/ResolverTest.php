<?php

namespace Tests\Rester;

use Corp104\Rester\Exceptions\InvalidResolverException;
use Tests\Fixture\TestResolverNotImplementResolveMethod;
use Tests\TestCase;

class ResolverTest extends TestCase
{
    /**
     * @test
     */
    public function shouldThrowExceptionWhenNotImplementResolveMethod(): void
    {
        $this->expectException(InvalidResolverException::class);

        $actual = new TestResolverNotImplementResolveMethod();

        $actual();
    }
}

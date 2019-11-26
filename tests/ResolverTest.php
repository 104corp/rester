<?php

namespace Tests\Rester;

use Tests\Fixture\TestResolverNotImplementResolveMethod;
use Tests\TestCase;

class ResolverTest extends TestCase
{
    /**
     * @test
     * @expectedException \Corp104\Rester\Exceptions\InvalidResolverException
     */
    public function shouldThrowExceptionWhenNotImplementResolveMethod()
    {
        $actual = new TestResolverNotImplementResolveMethod();

        $actual();
    }
}

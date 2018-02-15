<?php

namespace Tests\Rester;

use Corp104\Rester\ResterRequest;
use Tests\TestCase;

/**
 * RESTer request test
 */
class ResterRequestTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeOkayWhenCreateFromBinding()
    {
        $excepted = ['foo' => 'bar'];

        $target = ResterRequest::createFromBinding($excepted);

        $this->assertSame($excepted, $target->getBinding());
        $this->assertSame([], $target->getParsedBody());
        $this->assertSame([], $target->getQueryParams());
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCreateFromParsedBody()
    {
        $excepted = ['foo' => 'bar'];

        $target = ResterRequest::createFromParsedBody($excepted);

        $this->assertSame([], $target->getBinding());
        $this->assertSame($excepted, $target->getParsedBody());
        $this->assertSame([], $target->getQueryParams());
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCreateFromQueryParams()
    {
        $excepted = ['foo' => 'bar'];

        $target = ResterRequest::createFromQueryParams($excepted);

        $this->assertSame([], $target->getBinding());
        $this->assertSame([], $target->getParsedBody());
        $this->assertSame($excepted, $target->getQueryParams());
    }
}

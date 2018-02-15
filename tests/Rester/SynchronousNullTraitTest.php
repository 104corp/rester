<?php

namespace Tests\Rester;

use Corp104\Rester\SynchronousNullTrait;
use Tests\TestCase;

/**
 * SynchronousTrait test
 */
class SynchronousNullTraitTest extends TestCase
{
    /**
     * @var SynchronousNullTrait
     */
    protected $target;

    protected function setUp()
    {
        parent::setUp();

        $this->target = $this->getMockForTrait(SynchronousNullTrait::class);
    }

    protected function tearDown()
    {
        $this->target = null;

        parent::tearDown();
    }

    /**
     * @test
     */
    public function shouldAsyncWhenDefault()
    {
        $this->assertNull($this->target->isAsynchronous());
        $this->assertNull($this->target->isSynchronous());
    }

    /**
     * @test
     */
    public function shouldSyncWhenSetToSync()
    {
        $this->target->asynchronous();

        $this->assertFalse($this->target->isSynchronous());
        $this->assertTrue($this->target->isAsynchronous());

        $this->target->synchronous();

        $this->assertTrue($this->target->isSynchronous());
        $this->assertFalse($this->target->isAsynchronous());
    }
}

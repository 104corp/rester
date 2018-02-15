<?php

namespace Tests\Rester\Plugins;

use Corp104\Rester\Plugins\SynchronousTrait;
use Corp104\Rester\ResterClient;
use Tests\TestCase;

/**
 * SynchronousTrait test
 */
class SynchronousTraitTest extends TestCase
{
    /**
     * @var SynchronousTrait
     */
    protected $target;

    protected function setUp()
    {
        parent::setUp();

        $this->target = $this->getMockForTrait(SynchronousTrait::class);
    }

    protected function tearDown()
    {
        $this->target = null;

        parent::tearDown();
    }

    /**
     * @test
     */
    public function shouldSyncWhenDefault()
    {
        $this->assertTrue($this->target->isSynchronous());
        $this->assertFalse($this->target->isAsynchronous());
    }

    /**
     * @test
     */
    public function shouldAsyncWhenSetToAsync()
    {
        $this->target->asynchronous();

        $this->assertFalse($this->target->isSynchronous());
        $this->assertTrue($this->target->isAsynchronous());

        $this->target->synchronous();

        $this->assertTrue($this->target->isSynchronous());
        $this->assertFalse($this->target->isAsynchronous());
    }
}

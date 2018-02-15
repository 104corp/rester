<?php

namespace Tests\Rester\Plugins;

use Corp104\Rester\Plugins\AsynchronousTrait;
use Corp104\Rester\ResterClient;
use Tests\TestCase;

/**
 * AsynchronousTrait test
 */
class AsynchronousTraitTest extends TestCase
{
    /**
     * @var AsynchronousTrait
     */
    protected $target;

    protected function setUp()
    {
        parent::setUp();

        $this->target = $this->getMockForTrait(AsynchronousTrait::class);
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
        $this->assertTrue($this->target->isAsynchronous());
        $this->assertFalse($this->target->isSynchronous());
    }

    /**
     * @test
     */
    public function shouldSyncWhenSetToSync()
    {
        $this->target->synchronous();

        $this->assertTrue($this->target->isSynchronous());
        $this->assertFalse($this->target->isAsynchronous());

        $this->target->asynchronous();

        $this->assertFalse($this->target->isSynchronous());
        $this->assertTrue($this->target->isAsynchronous());
    }
}

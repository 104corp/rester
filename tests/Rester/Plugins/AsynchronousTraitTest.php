<?php

namespace Tests\Rester\Plugins;

use Corp104\Rester\Plugins\AsynchronousTrait;
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

    protected function setUp(): void
    {
        parent::setUp();

        $this->target = $this->getMockForTrait(AsynchronousTrait::class);
    }

    protected function tearDown(): void
    {
        $this->target = null;

        parent::tearDown();
    }

    /**
     * @test
     */
    public function shouldAsyncWhenDefault(): void
    {
        $this->assertTrue($this->target->isAsynchronous());
        $this->assertFalse($this->target->isSynchronous());
    }
}

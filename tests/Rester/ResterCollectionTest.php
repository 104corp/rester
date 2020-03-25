<?php

namespace Tests\Rester;

use Corp104\Rester\Exceptions\CollectionNotFoundException;
use Corp104\Rester\Exceptions\InvalidArgumentException;
use Corp104\Rester\Exceptions\OperationDeniedException;
use Corp104\Rester\ResterClientInterface;
use Corp104\Rester\ResterCollection;
use Corp104\Rester\ResterMix;
use Tests\Fixture\TestResterCollection;
use Tests\TestCase;

class ResterCollectionTest extends TestCase
{
    /**
     * @var TestResterCollection
     */
    protected $target;

    protected function setUp(): void
    {
        parent::setUp();

        $this->target = new TestResterCollection();
    }

    protected function tearDown(): void
    {
        $this->target = null;

        parent::tearDown();
    }

    /**
     * @test
     */
    public function shouldGetTestClientWhenCallGetCollection(): void
    {
        $this->assertTrue($this->target->hasCollection('tester'));
        $this->assertInstanceOf(ResterClientInterface::class, $this->target->getCollection('tester'));
    }

    /**
     * @test
     */
    public function shouldGetTestClientWhenUsingMagicMethodToGetCollection(): void
    {
        $this->assertTrue(isset($this->target->tester));
        $this->assertInstanceOf(ResterClientInterface::class, $this->target->tester);
    }

    /**
     * @test
     */
    public function shouldReturnFalseWhenUsingMagicMethodToCheckCollectionIsExist(): void
    {
        $this->assertFalse(isset($this->target->unknown));
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenCallGetCollectionWithCollectionIsNotExist(): void
    {
        $this->expectException(CollectionNotFoundException::class);

        $this->target->getCollection('unknown');
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenUsingMagicMethodWithCollectionIsNotExist(): void
    {
        $this->expectException(CollectionNotFoundException::class);

        $this->target->unknown;
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenSetResterClientProperty(): void
    {
        $resterClientMock = $this->getMockBuilder(ResterClientInterface::class)
            ->getMock();

        $this->target->newOne = $resterClientMock;

        $this->assertInstanceOf(ResterClientInterface::class, $this->target->newOne);
        $this->assertSame($resterClientMock, $this->target->newOne);
        $this->assertTrue($this->target->hasCollection('newOne'));
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenSetNotResterClientProperty(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->target->unknown = new \stdClass();
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenUnsetCollectionProperty(): void
    {
        $this->expectException(OperationDeniedException::class);

        unset($this->target->tester);
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenSetNestResterCollection(): void
    {
        $excepted = new ResterMix();
        $excepted2 = new ResterCollection();

        $this->target->nestCollection = $excepted;
        $this->target->nestCollection->nestCollection2 = $excepted2;

        $this->assertSame($excepted, $this->target->nestCollection);
        $this->assertSame($excepted2, $this->target->nestCollection->nestCollection2);
    }
}

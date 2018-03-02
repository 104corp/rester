<?php

namespace Tests\Rester;

use Corp104\Rester\Exceptions\CollectionNotFoundException;
use Corp104\Rester\Exceptions\InvalidArgumentException;
use Corp104\Rester\Exceptions\OperationDeniedException;
use Corp104\Rester\ResterClient;
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

    protected function setUp()
    {
        parent::setUp();

        $this->target = new TestResterCollection();
    }

    protected function tearDown()
    {
        $this->target = null;

        parent::tearDown();
    }

    /**
     * @test
     */
    public function shouldGetTestClientWhenCallGetCollection()
    {
        $this->assertTrue($this->target->hasCollection('tester'));
        $this->assertInstanceOf(ResterClientInterface::class, $this->target->getCollection('tester'));
    }

    /**
     * @test
     */
    public function shouldGetTestClientWhenUsingMagicMethodToGetCollection()
    {
        $this->assertTrue(isset($this->target->tester));
        $this->assertInstanceOf(ResterClientInterface::class, $this->target->tester);
    }

    /**
     * @test
     */
    public function shouldReturnFalseWhenUsingMagicMethodToCheckCollectionIsExist()
    {
        $this->assertFalse(isset($this->target->unknown));
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenCallGetCollectionWithCollectionIsNotExist()
    {
        $this->setExpectedException(CollectionNotFoundException::class);

        $this->target->getCollection('unknown');
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenUsingMagicMethodWithCollectionIsNotExist()
    {
        $this->setExpectedException(CollectionNotFoundException::class);

        $this->target->unknown;
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenSetResterClientProperty()
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
    public function shouldThrowExceptionWhenSetNotResterClientProperty()
    {
        $this->setExpectedException(
            InvalidArgumentException::class,
            'Given is ' . \stdClass::class
        );

        $this->target->unknown = new \stdClass();
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenUnsetCollectionProperty()
    {
        $this->setExpectedException(OperationDeniedException::class);

        unset($this->target->tester);
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenSetNestResterCollection()
    {
        $excepted = new ResterMix();
        $excepted2 = new ResterCollection();

        $this->target->nestCollection = $excepted;
        $this->target->nestCollection->nestCollection2 = $excepted2;

        $this->assertSame($excepted, $this->target->nestCollection);
        $this->assertSame($excepted2, $this->target->nestCollection->nestCollection2);
    }
}

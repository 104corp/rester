<?php

namespace Tests\Rester;

use Corp104\Rester\Exceptions\CollectionNotFoundException;
use Corp104\Rester\Exceptions\InvalidArgumentException;
use Corp104\Rester\Exceptions\OperationDeniedException;
use Corp104\Rester\ResterClientInterface;
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
        $this->expectException(CollectionNotFoundException::class);

        $this->target->getCollection('unknown');
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenUsingMagicMethodWithCollectionIsNotExist()
    {
        $this->expectException(CollectionNotFoundException::class);

        $this->target->unknown;
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenSetResterClientProperty()
    {
        $resterClientMock = $this->createMock(ResterClientInterface::class);

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
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Given is ' . \stdClass::class);

        $this->target->unknown = new \stdClass();
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenUnsetCollectionProperty()
    {
        $this->expectException(OperationDeniedException::class);

        unset($this->target->tester);
    }
}

<?php

namespace Tests\Rester\Api;

use Corp104\Rester\Api\Api;
use Corp104\Rester\Exceptions\InvalidArgumentException;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * @test
     */
    public function shouldThrowInvalidArgumentExceptionWhenPassUnknownHttpMethod()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $this->getMockForAbstractClass(
            Api::class,
            ['Unknown', '/foo']
        );
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallGetMethod()
    {
        /** @var Api $target */
        $target = $this->getMockForAbstractClass(
            Api::class,
            ['GET', '/foo']
        );

        $this->assertSame('GET', $target->getMethod());
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallGetUriBindingKeys()
    {
        /** @var Api $target */
        $target = $this->getMockForAbstractClass(
            Api::class,
            ['GET', '/{foo}/{bar}']
        );

        $excepted = ['foo', 'bar'];

        $this->assertSame($excepted, $target->getUriBindingKeys());
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallGetUriWithAndWithoutBinding()
    {
        /** @var Api $target */
        $target = $this->getMockForAbstractClass(
            Api::class,
            ['GET', '/some/{foo}/bar/{baz}']
        );

        $this->assertSame('/some/{foo}/bar/{baz}', $target->getUri());
        $this->assertSame('/some', $target->getUriWithoutBinding());
    }

    /**
     * @test
     */
    public function shouldBindPathOkWithoutBinding()
    {
        /** @var Api $target */
        $target = $this->getMockForAbstractClass(
            Api::class,
            ['GET', '/foo']
        );

        $this->assertSame('/foo', $target->bindUri());
    }

    /**
     * @test
     */
    public function shouldBindPathOk()
    {
        /** @var Api $target */
        $target = $this->getMockForAbstractClass(
            Api::class,
            ['GET', '/foo/{bar}']
        );

        $actual = $target->bindUri(['bar' => 'some']);

        $this->assertSame('/foo/some', $actual);
    }

    /**
     * @test
     */
    public function shouldBuildOkayWhenUsingSequenceArray()
    {
        /** @var Api $target */
        $target = $this->getMockForAbstractClass(
            Api::class,
            ['GET', '/foo/{bar}/{baz}']
        );

        $actual = $target->bindUri(['some', 'str']);

        $this->assertSame('/foo/some/str', $actual);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenSequenceArrayAndBindingCountIsNotMatch()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        /** @var Api $target */
        $target = $this->getMockForAbstractClass(
            Api::class,
            ['GET', '/foo/{bar}/{baz}']
        );

        $target->bindUri(['onlyone']);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenBindingNotComplete()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        /** @var Api $target */
        $target = $this->getMockForAbstractClass(
            Api::class,
            ['GET', '/foo/{bar}/{baz}']
        );

        $target->bindUri(['bar' => 'some']);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenBindingNotCompleteWithEmptyBinding()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        /** @var Api $target */
        $target = $this->getMockForAbstractClass(
            Api::class,
            ['GET', '/foo/{bar}']
        );

        $target->bindUri();
    }
}

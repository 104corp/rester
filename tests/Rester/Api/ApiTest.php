<?php

namespace Tests\Rester\Api;

use Corp104\Rester\Api\Api;
use InvalidArgumentException;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * @test
     */
    public function shouldThrowInvalidArgumentExceptionWhenPassUnknownHttpMethod(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->getMockForAbstractClass(
            Api::class,
            ['Unknown', '/foo']
        );
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCallGetMethod(): void
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
    public function shouldBeOkayWhenCallGetUriBindingKeys(): void
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
    public function shouldBeOkayWhenCallGetUriWithAndWithoutBinding(): void
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
    public function shouldBindPathOkWithoutBinding(): void
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
    public function shouldBindPathOk(): void
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
    public function shouldBuildOkayWhenUsingSequenceArray(): void
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
    public function shouldThrowExceptionWhenSequenceArrayAndBindingCountIsNotMatch(): void
    {
        $this->expectException(InvalidArgumentException::class);

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
    public function shouldThrowExceptionWhenBindingNotComplete(): void
    {
        $this->expectException(InvalidArgumentException::class);

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
    public function shouldThrowExceptionWhenBindingNotCompleteWithEmptyBinding(): void
    {
        $this->expectException(InvalidArgumentException::class);

        /** @var Api $target */
        $target = $this->getMockForAbstractClass(
            Api::class,
            ['GET', '/foo/{bar}']
        );

        $target->bindUri();
    }
}

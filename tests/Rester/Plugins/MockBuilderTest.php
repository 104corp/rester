<?php

namespace Tests\Rester\Plugins;

use Corp104\Rester\ResterClient;
use Tests\Fixture\TestResterClientWithMockBuilder;
use Tests\TestCase;

/**
 * Mock builder test
 */
class MockBuilderTest extends TestCase
{
    /**
     * @var ResterClient
     */
    protected $target;

    /**
     * @test
     */
    public function shouldReturnCorrectDataWhenSettingMockWithMakePartial(): void
    {
        $excepted = 'something';

        $clientMock = TestResterClientWithMockBuilder::createMock([
            'getFoo' => $excepted,
        ]);

        $this->assertSame($excepted, $clientMock->getFoo());
    }

    /**
     * @test
     */
    public function shouldReturnCorrectDataWhenSettingMock(): void
    {
        $excepted = 'something';

        $clientMock = TestResterClientWithMockBuilder::createMock([
            'getFoo' => $excepted,
        ], false);

        $this->assertSame($excepted, $clientMock->getFoo());
    }

    /**
     * @test
     */
    public function shouldBeOkayWithoutSetting(): void
    {
        $clientMock = TestResterClientWithMockBuilder::createMock();

        $this->assertNull($clientMock->getHttpClient());
    }
}

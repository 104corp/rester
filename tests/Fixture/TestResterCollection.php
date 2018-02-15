<?php

namespace Tests\Fixture;

use Corp104\Rester\ResterCollection;

/**
 * @property TestResterClient tester
 */
class TestResterCollection extends ResterCollection
{
    public function __construct()
    {
        $this->provisionCollection([
            'tester' => new TestResterClient(),
        ]);
    }
}

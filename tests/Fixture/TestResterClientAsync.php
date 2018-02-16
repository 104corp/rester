<?php

namespace Tests\Fixture;

/**
 * Async client
 */
class TestResterClientAsync extends TestResterClient
{
    public function __construct()
    {
        parent::__construct();

        $this->asynchronous();
    }
}

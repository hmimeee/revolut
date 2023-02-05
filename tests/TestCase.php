<?php

namespace Hmimeee\Revolut;

use PHPUnit\Framework\TestCase as Test;

class TestCase extends Test
{
    protected Revolut $revolut;

    protected function setUp(): void
    {
        parent::setUp();
        $this->prepareTest();
    }

    /**
     * Prepare the Test before run
     */
    private function prepareTest(): void
    {
        $this->revolut = getRevolut([
            'key' => 'Test' //TODO: Pleasse add your key here before run test
        ]);
    }
}

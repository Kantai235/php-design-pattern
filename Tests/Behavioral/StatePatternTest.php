<?php

namespace Tests\Behavioral;

use DesignPatterns\Behavioral\StatePattern\Turnips;
use PHPUnit\Framework\TestCase;

/**
 * Class StatePatternTest.
 */
class StatePatternTest extends TestCase
{
    /**
     * @test
     */
    public function test_state_spoiled()
    {
        $turnips = Turnips::create(100, 40);

        $this->assertSame('created', $turnips->toString());
        $this->assertEquals(4000, $turnips->calculatePrice());

        $turnips->proceedToNext();

        $this->assertSame('spoiled', $turnips->toString());
        $this->assertEquals(0, $turnips->calculatePrice());
    }
}

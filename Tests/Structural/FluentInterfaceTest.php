<?php

namespace Tests\Structural;

use DesignPatterns\Structural\FluentInterface\Turnips;
use PHPUnit\Framework\TestCase;

/**
 * Class FluentInterfaceTest.
 */
class FluentInterfaceTest extends TestCase
{
    /**
     * @test
     */
    public function test_build_turnips()
    {
        $turnips = (new Turnips())
            ->price(100)
            ->count(40);

        $this->assertEquals(4000, $turnips->calculatePrice());
    }
}

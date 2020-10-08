<?php

namespace Tests\Behavioral;

use DesignPatterns\Behavioral\StrategyPattern\SpoliedStrategy;
use DesignPatterns\Behavioral\StrategyPattern\Turnips;
use DesignPatterns\Behavioral\StrategyPattern\TurnipsStrategy;
use PHPUnit\Framework\TestCase;

/**
 * Class StrategyPatternTest.
 */
class StrategyPatternTest extends TestCase
{
    /**
     * @test
     */
    public function test_strategy()
    {
        $turnips = new Turnips(100, 40, new TurnipsStrategy);
        $this->assertEquals(4000, $turnips->calculatePrice());

        $turnips->setStrategy(new SpoliedStrategy());
        $this->assertEquals(0, $turnips->calculatePrice());
    }
}

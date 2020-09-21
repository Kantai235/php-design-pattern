<?php

namespace Tests\Behavioral;

use DesignPatterns\Behavioral\MementoPattern\Turnips;
use PHPUnit\Framework\TestCase;

/**
 * Class MementoPatternTest.
 */
class MementoPatternTest extends TestCase
{
    /**
     * @test
     */
    public function test_bites_the_dust()
    {
        $turnips = new Turnips(100, 40);
        $this->assertEquals(4000, $turnips->calculatePrice());

        /**
         * 儲存當前時空
         */
        $memento = $turnips->saveToMemento();

        $newPrice = random_int(0, 600);
        $turnips->setPrice($newPrice);
        $this->assertEquals($newPrice * 40, $turnips->calculatePrice());

        /**
         * 到極限了，就是現在，按下去！
         */
        $turnips->restoreFromMemento($memento);
        $this->assertEquals(4000, $turnips->calculatePrice());
    }
}

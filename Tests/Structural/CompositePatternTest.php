<?php

namespace Tests\Structural;

use DesignPatterns\Structural\CompositePattern\PriceDown;
use DesignPatterns\Structural\CompositePattern\PriceUp;
use DesignPatterns\Structural\CompositePattern\Turnips;
use PHPUnit\Framework\TestCase;

/**
 * Class CompositePatternTest.
 */
class CompositePatternTest extends TestCase
{
    /**
     * 測試鈴錢價格上漲物件是否能夠正常運作。
     * 
     * @test
     */
    public function test_price_up()
    {
        $price = new PriceUp(20);
        $this->assertEquals(20, $price->calculatePrice());
    }

    /**
     * 測試鈴錢價格下跌物件是否能夠正常運作。
     * 
     * @test
     */
    public function test_price_down()
    {
        $price = new PriceDown(20);
        $this->assertEquals(-20, $price->calculatePrice());
    }

    /**
     * 測試鈴錢價格上漲物件、鈴錢價格下跌物件實際組裝起來再各別計算一次。
     * 
     * @test
     */
    public function test_price_up_and_down()
    {
        $turnips = new Turnips(100, 40);
        $this->assertEquals(4000, $turnips->calculatePrice());

        $turnips->addElement(new PriceUp(20));
        $this->assertEquals(4800, $turnips->calculatePrice());

        $turnips->addElement(new PriceDown(30));
        $this->assertEquals(3600, $turnips->calculatePrice());
    }
}

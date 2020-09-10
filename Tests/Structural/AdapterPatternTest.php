<?php

namespace Tests\Structural;

use DesignPatterns\Structural\AdapterPattern\Turnips;
use DesignPatterns\Structural\AdapterPattern\TurnipsAdapter;
use PHPUnit\Framework\TestCase;

/**
 * Class AdapterPatternTest.
 */
class AdapterPatternTest extends TestCase
{
    /**
     * 測試大頭菜是否能夠正常賦予數量及價格，並且漲價 10 鈴錢、減少 20 組，最後算出價格是否符合。
     * 
     * @test
     */
    public function test_can_rise_price_and_sub_count_on_turnips()
    {
        $turnips = new Turnips(100, 40);
        $turnips->risePrice(10);
        $turnips->subCount(20);

        $this->assertEquals(2200, $turnips->calculatePrice());
    }

    /**
     * 測試大頭菜是否能夠正常賦予數量及價格，並且透過大頭菜轉接器把它轉成壞掉的大頭菜
     * 最後漲價 10 鈴錢、減少 20 組，最後算出價格是否根本沒辦法賣鈴錢。
     * 
     * @test
     */
    public function test_can_rise_price_and_sub_count_on_spoiled()
    {
        $turnips = new Turnips(100, 40);
        $turnipsAdapter = new TurnipsAdapter($turnips);
        $turnipsAdapter->risePrice(10);
        $turnipsAdapter->subCount(20);

        $this->assertEquals(0, $turnipsAdapter->calculatePrice());
    }
}

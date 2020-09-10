<?php

namespace DesignPatterns\Structural\Facade\Tests;

use DesignPatterns\Structural\FacadePattern\Facade;
use DesignPatterns\Structural\FacadePattern\Bag;
use DesignPatterns\Structural\FacadePattern\DaisyMae;
use DesignPatterns\Structural\FacadePattern\Store;
use PHPUnit\Framework\TestCase;

/**
 * Class FacadePatternTest.
 */
class FacadePatternTest extends TestCase
{
    /**
     * @test
     */
    public function test_buy_and_sell_turnips()
    {
        $bag = new Bag();
        $store = new Store();
        $daisyMae = new DaisyMae();
        $facade = new Facade($bag, $store, $daisyMae);

        // 在背包裡塞入 10,000 鈴錢
        $this->assertEquals(10000, $facade->takeupBells(10000));

        // 購買 40 顆單價 100 鈴錢的大頭菜
        $this->assertEquals(6000 ,$facade->buyTurnips(100, 40));

        // 以 400 鈴錢賣出 20 顆大頭菜
        $this->assertEquals(14000 ,$facade->sellTurnips(400, 20));

        // 從背包拿出 10,000 鈴錢
        $this->assertEquals(4000 ,$facade->takeoutBells(10000));

        // 再 600 鈴錢賣出 20 顆大頭菜
        $this->assertEquals(16000 ,$facade->sellTurnips(600, 20));
    }
}

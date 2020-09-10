<?php

namespace Tests\Creational;

use DesignPatterns\Creational\SimpleFactory\Turnips;
use DesignPatterns\Creational\SimpleFactory\TurnipsFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class SimpleFactoryTest.
 */
class SimpleFactoryTest extends TestCase
{
    /**
     * 測試是否能夠正常建立大頭菜。
     * 
     * @test
     */
    public function test_can_create_turnip()
    {
        $turnips = (new TurnipsFactory())->createTurnips();

        $this->assertInstanceOf(Turnips::class, $turnips);
    }

    /**
     * 測試建立的大頭菜是否能夠用正常價格買入。
     * 
     * @test
     */
    public function test_can_buy_turnip()
    {
        $turnips = (new TurnipsFactory())->createTurnips();
        $price = $turnips->buy(100, 40);

        $this->assertEquals(4000, $price);
    }

    /**
     * 測試建立的大頭菜是否能夠正常計算價格。
     * 
     * @test
     */
    public function test_can_calculate_price()
    {
        $turnips = (new TurnipsFactory())->createTurnips();
        $turnips->buy(100, 40);
        $price = $turnips->calculatePrice();

        $this->assertEquals(4000, $price);
    }

    /**
     * 測試建立的大頭菜如果沒有買過，那是不是能夠回傳 0 鈴錢。
     * 
     * @test
     */
    public function test_can_calculate_price_error()
    {
        $turnips = (new TurnipsFactory())->createTurnips();

        $this->assertEquals(0, $turnips->calculatePrice());
    }
}

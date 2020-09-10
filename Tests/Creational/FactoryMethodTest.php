<?php

namespace Tests\Creational;

use DesignPatterns\Creational\FactoryMethod\Turnips;
use DesignPatterns\Creational\FactoryMethod\TurnipsFactory;
use DesignPatterns\Creational\FactoryMethod\SpoiledTurnips;
use DesignPatterns\Creational\FactoryMethod\SpoiledTurnipsFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class FactoryMethodTest.
 */
class FactoryMethodTest extends TestCase
{
    /**
     * 測試是否能夠正常建立大頭菜。
     * 
     * @test
     */
    public function test_can_create_turnips()
    {
        $factory = new TurnipsFactory(100, 40);
        $turnips = $factory->createTurnips();

        $this->assertInstanceOf(Turnips::class, $turnips);
    }

    /**
     * 測試是否能夠正常建立壞掉的大頭菜。
     * 
     * @test
     */
    public function test_can_create_spoiled_turnips()
    {
        $factory = new SpoiledTurnipsFactory(40);
        $turnips = $factory->createTurnips();
        
        $this->assertInstanceOf(SpoiledTurnips::class, $turnips);
    }

    /**
     * 測試是否能夠正常計算大頭菜的價格。
     * 
     * @test
     */
    public function test_can_calculate_price_for_turnips()
    {
        $factory = new TurnipsFactory(100, 40);
        $turnips = $factory->createTurnips();

        $this->assertEquals(4000, $turnips->calculatePrice());
    }

    /**
     * 測試是否能夠正常計算壞掉的大頭菜的價格。
     * 
     * @test
     */
    public function test_can_calculate_price_for_spoiled_turnips()
    {
        $factory = new SpoiledTurnipsFactory(40);
        $turnips = $factory->createTurnips();

        $this->assertEquals(0, $turnips->calculatePrice());
    }
}

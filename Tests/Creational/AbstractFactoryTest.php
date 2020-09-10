<?php

namespace Tests\Creational;

use DesignPatterns\Creational\AbstractFactory\Turnips;
use DesignPatterns\Creational\AbstractFactory\TurnipsFactory;
use DesignPatterns\Creational\AbstractFactory\SpoiledTurnips;
use DesignPatterns\Creational\AbstractFactory\SpoiledTurnipsFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractFactoryTest.
 */
class AbstractFactoryTest extends TestCase
{
    /**
     * 測試是否能夠建立大頭菜。
     * 
     * @test
     */
    public function test_can_create_turnips()
    {
        $factory = new TurnipsFactory();
        $turnips = $factory->createTurnips('大頭菜', 100, 40);

        $this->assertInstanceOf(Turnips::class, $turnips);
    }

    /**
     * 測試是否能夠建立壞掉的大頭菜。
     * 
     * @test
     */
    public function test_can_create_spoiled_turnips()
    {
        $factory = new SpoiledTurnipsFactory();
        $turnips = $factory->createTurnips('壞掉的大頭菜', 100, 40);

        $this->assertInstanceOf(SpoiledTurnips::class, $turnips);
    }

    /**
     * 測試大頭菜是否能夠正常計算價格。
     * 
     * @test
     */
    public function test_can_calculate_price_for_turnips()
    {
        $factory = new TurnipsFactory();
        $turnips = $factory->createTurnips('大頭菜', 100, 40);

        $this->assertEquals(4000, $turnips->calculatePrice());
    }

    /**
     * 測試壞掉的大頭菜是否能夠正常計算價格。
     * 
     * @test
     */
    public function test_can_calculate_price_for_spoiled_turnips()
    {
        $factory = new SpoiledTurnipsFactory();
        $turnips = $factory->createTurnips('壞掉的大頭菜', 100, 40);

        $this->assertEquals(0, $turnips->calculatePrice());
    }
}

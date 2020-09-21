<?php

namespace Tests\Creational;

use DesignPatterns\Creational\StaticFactory\Turnips;
use DesignPatterns\Creational\StaticFactory\TurnipsFactory;
use DesignPatterns\Creational\StaticFactory\SpoiledTurnips;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Class StaticFactoryTest.
 */
class StaticFactoryTest extends TestCase
{
    /**
     * 測試是否能夠正常建立大頭菜。
     * 
     * @test
     */
    public function test_can_create_turnips()
    {
        $this->assertInstanceOf(Turnips::class, TurnipsFactory::factory('大頭菜', 100, 40));
    }

    /**
     * 測試是否能夠正常建立壞掉的大頭菜。
     * 
     * @test
     */
    public function test_can_create_spoiled_turnips()
    {
        $this->assertInstanceOf(SpoiledTurnips::class, TurnipsFactory::factory('壞掉的大頭菜', 100, 40));
    }

    /**
     * 測試是否能夠正常計算大頭菜的價格。
     * 
     * @test
     */
    public function test_can_calculate_price_for_turnips()
    {
        $turnips = TurnipsFactory::factory('大頭菜', 100, 40);

        $this->assertEquals(4000, $turnips->calculatePrice());
    }

    /**
     * 測試是否能夠正常計算壞掉的大頭菜的價格。
     * 
     * @test
     */
    public function test_can_calculate_price_for_spoiled_turnips()
    {
        $turnips = TurnipsFactory::factory('壞掉的大頭菜', 100, 40);

        $this->assertEquals(0, $turnips->calculatePrice());
    }

    /**
     * 測試是否能夠收到未知的大頭菜。
     * 
     * @test
     */
    public function testException()
    {
        $this->expectException(InvalidArgumentException::class);

        TurnipsFactory::factory('未知的大頭菜', 0, 0);
    }
}

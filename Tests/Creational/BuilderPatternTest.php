<?php

namespace Tests\Creational;

use DesignPatterns\Creational\BuilderPattern\Director;
use DesignPatterns\Creational\BuilderPattern\TurnipsBuilder;
use DesignPatterns\Creational\BuilderPattern\SpoiledTurnipsBuilder;
use DesignPatterns\Creational\BuilderPattern\Parts\Turnips;
use DesignPatterns\Creational\BuilderPattern\Parts\SpoiledTurnips;
use PHPUnit\Framework\TestCase;

/**
 * Class BuilderPatternTest.
 */
class BuilderPatternTest extends TestCase
{
    /**
     * 測試是否能夠正常建立大頭菜。
     * 
     * @test
     */
    public function test_can_build_turnips()
    {
        $builder = new TurnipsBuilder();
        $turnips = (new Director())->build($builder, 100, 40);

        $this->assertInstanceOf(Turnips::class, $turnips);
    }

    /**
     * 測試是否能夠正常建立壞掉的大頭菜。
     * 
     * @test
     */
    public function test_can_build_spoiled_turnips()
    {
        $builder = new SpoiledTurnipsBuilder();
        $turnips = (new Director())->build($builder, 100, 40);

        $this->assertInstanceOf(SpoiledTurnips::class, $turnips);
    }

    /**
     * 測試大頭菜是否能夠正常計算價格。
     * 
     * @test
     */
    public function test_can_calculate_price_for_turnips()
    {
        $builder = new TurnipsBuilder();
        $turnips = (new Director())->build($builder, 100, 40);

        $this->assertEquals(4000, $turnips->calculatePrice());
    }

    /**
     * 測試壞掉的大頭菜是否能夠正常計算價格。
     * 
     * @test
     */
    public function test_can_calculate_price_for_spoiled_turnips()
    {
        $builder = new SpoiledTurnipsBuilder();
        $turnips = (new Director())->build($builder, 100, 40);

        $this->assertEquals(0, $turnips->calculatePrice());
    }
}

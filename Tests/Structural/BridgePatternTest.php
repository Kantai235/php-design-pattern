<?php

namespace Tests\Structural;

use DesignPatterns\Structural\BridgePattern\Spoiled;
use DesignPatterns\Structural\BridgePattern\Turnips;
use DesignPatterns\Structural\BridgePattern\TurnipsService;
use PHPUnit\Framework\TestCase;

/**
 * Class BridgePatternTest.
 */
class BridgePatternTest extends TestCase
{
    /**
     * 測試是否能建立 Service 並把健康的大頭菜塞進去，然後計算鈴錢。
     * 
     * @test
     */
    public function test_can_calculate_price_for_turnips()
    {
        $service = new TurnipsService(new Turnips(100, 40));
        $this->assertEquals(4000, $service->calculatePrice());
    }
    
    /**
     * 測試是否能建立 Service 並把壞掉的大頭菜塞進去，然後計算鈴錢。
     * 
     * @test
     */
    public function test_can_calculate_price_for_spoiled()
    {
        $service = new TurnipsService(new Spoiled(100, 40));
        $this->assertEquals(0, $service->calculatePrice());
    }
    
    /**
     * 測試是否能建立 Service 並把健康的大頭菜塞進去，然後計算鈴錢，
     * 再把大頭菜替換成壞掉的大頭菜，再計算一次鈴錢。
     * 
     * @test
     */
    public function test_can_calculate_price_for_turnips_and_spoiled()
    {
        $service = new TurnipsService(new Turnips(100, 40));
        $this->assertEquals(4000, $service->calculatePrice());

        $service->setImplementation(new Spoiled(100, 40));
        $this->assertEquals(0, $service->calculatePrice());
    }
}

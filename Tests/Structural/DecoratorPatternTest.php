<?php

namespace Tests\Structural;

use DesignPatterns\Structural\DecoratorPattern\Spoiled;
use DesignPatterns\Structural\DecoratorPattern\Turnips;
use DesignPatterns\Structural\DecoratorPattern\TurnipsService;
use PHPUnit\Framework\TestCase;

/**
 * Class DecoratorPatternTest.
 */
class DecoratorPatternTest extends TestCase
{
    /**
     * 測試正常的大頭菜是否可以賣鈴錢。
     * 
     * @test
     */
    public function test_turnips()
    {
        $service = new TurnipsService(100, 40);
        $turnips = new Turnips($service);

        $this->assertEquals(4000, $turnips->calculatePrice());
    }

    /**
     * 測試壞掉的大頭菜是否沒辦法賣鈴錢。
     * 
     * @test
     */
    public function test_spoiled()
    {
        $service = new TurnipsService(100, 40);
        $turnips = new Spoiled($service);

        $this->assertEquals(0, $turnips->calculatePrice());
    }
}

<?php

namespace Tests\Structural;

use DesignPatterns\Structural\DependencyInjection\Turnips;
use DesignPatterns\Structural\DependencyInjection\TurnipsConfiguration;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Class DependencyInjectionTest.
 */
class DependencyInjectionTest extends TestCase
{
    /**
     * 測試正常的大頭菜是否可以賣鈴錢。
     * 
     * @test
     */
    public function test_turnips_dependency_injection()
    {
        $config = new TurnipsConfiguration('健康的大頭菜', 100, 40);
        $turnips = new Turnips($config);

        $this->assertEquals(4000, $turnips->calculatePrice());
    }

    /**
     * 測試壞掉的大頭菜是否鈴錢價格為 0。
     * 
     * @test
     */
    public function test_spoiled_dependency_injection()
    {
        $config = new TurnipsConfiguration('壞掉的大頭菜', 100, 40);
        $turnips = new Turnips($config);

        $this->assertEquals(0, $turnips->calculatePrice());
    }

    /**
     * 測試大頭菜組態檔如果給予不正確的類別，會獲得預期的錯誤。
     * 
     * @test
     */
    public function test_undefined_dependency_injection()
    {
        $this->expectException(InvalidArgumentException::class);

        $config = new TurnipsConfiguration('未知的大頭菜', 0, 0);
    }
}

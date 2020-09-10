<?php

namespace Tests\Structural;

use DesignPatterns\Structural\ProxyPattern\TurnipsProxy;
use PHPUnit\Framework\TestCase;

/**
 * Class ProxyPatternTest.
 */
class ProxyPatternTest extends TestCase
{
    /**
     * 透過代理來計算鈴錢總價。
     * 
     * @test
     */
    public function test_proxy_calculate_price()
    {
        $turnips = new TurnipsProxy(100, 40);
        $this->assertEquals(4000, $turnips->calculateTotal());
    }

    /**
     * 透過代理來計算鈴錢總價，並且鈴錢總價只會計算一次，並不會因為後續更改而變更。
     * 
     * @test
     */
    public function test_proxy_will_only_execute_calculate_price_once()
    {
        $turnips = new TurnipsProxy(100, 40);
        $this->assertEquals(4000, $turnips->calculateTotal());

        $turnips->setPrice(200);
        $turnips->setCount(30);
        $this->assertEquals(4000, $turnips->calculateTotal());
    }
}

<?php

namespace Tests\Creational;

use DesignPatterns\Creational\PrototypePattern\Turnips;
use DesignPatterns\Creational\PrototypePattern\SpoiledTurnips;
use PHPUnit\Framework\TestCase;

/**
 * Class PrototypePatternTest.
 */
class PrototypePatternTest extends TestCase
{
    /**
     * 建立大頭菜，並且複製 10 次，
     * 檢查每次大頭菜是否都是大頭菜，而且價格是正確的。
     * 
     * @test
     */
    public function test_can_clone_turnips()
    {
        $turnips = new Turnips(100, 40);

        for ($i = 0; $i < 10; $i++) {
            $_turnips = clone $turnips;

            $this->assertInstanceOf(Turnips::class, $_turnips);
            $this->assertEquals(4000, $_turnips->calculatePrice());
        }
    }

    /**
     * 建立壞掉的大頭菜，並且複製 10 次，
     * 檢查每次大頭菜是否都是壞掉的大頭菜，而且都賣不了錢。
     * 
     * @test
     */
    public function test_can_clone_spoiled_turnips()
    {
        $turnips = new SpoiledTurnips(100, 40);

        for ($i = 0; $i < 10; $i++) {
            $_turnips = clone $turnips;
            $this->assertInstanceOf(SpoiledTurnips::class, $_turnips);
            $this->assertEquals(0, $_turnips->calculatePrice());
        }
    }
}

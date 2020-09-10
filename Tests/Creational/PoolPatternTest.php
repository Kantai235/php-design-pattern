<?php

namespace Tests\Creational;

use DesignPatterns\Creational\PoolPattern\Turnips;
use DesignPatterns\Creational\PoolPattern\TurnipsPool;
use PHPUnit\Framework\TestCase;

/**
 * Class PoolPatternTest.
 */
class PoolPatternTest extends TestCase
{
    /**
     * 測試是否能夠正常的新增 10 組大頭菜，
     * 並且把大頭菜拿出 2 組後，檢查池子裡面是否剩下 8 組大頭菜，
     * 然後比較一下拿出來的這 2 組是不是兩個不同的大頭菜，
     * 最後比較一下大頭菜池子裡的大頭菜價格是不是正確的。
     * 
     * @test
     */
    public function test_can_set_new_turnips_and_get()
    {
        $pool = new TurnipsPool();
        for ($i = 0; $i < 10; $i++) {
            $turnips = new Turnips(100, 40);
            $pool->set($turnips);
        }

        $turnips1 = $pool->get();
        $turnips2 = $pool->get();

        $this->assertCount(8, $pool);
        $this->assertNotSame($turnips1, $turnips2);
        $this->assertEquals(32000, $pool->total());
    }

    /** 
     * 測試是否能夠正常的新增 10 組大頭菜，
     * 並且把大頭菜拿出 1 組後，馬上把大頭菜丟回去池子裡，
     * 再從池子裡拿出 1 組大頭菜，
     * 檢查池子裡面是否剩下 9 組大頭菜，
     * 然後比較一下最後拿出來的這組，是不是就是一開始拿出來的那組大頭菜，
     * 最後比較一下大頭菜池子裡的大頭菜價格是不是正確的。
     * 
     * @test
     */
    public function test_can_get_turnips_twice_when_set_it_first()
    {
        $pool = new TurnipsPool();
        for ($i = 0; $i < 10; $i++) {
            $turnips = new Turnips(100, 40);
            $pool->set($turnips);
        }

        $turnips1 = $pool->get();
        $pool->set($turnips1);

        $turnips2 = $pool->get();

        $this->assertCount(9, $pool);
        $this->assertSame($turnips1, $turnips2);
        $this->assertEquals(36000, $pool->total());
    }
}

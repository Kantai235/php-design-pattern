<?php

namespace Tests\Behavioral;

use DesignPatterns\Behavioral\ObserverPattern\Island;
use DesignPatterns\Behavioral\ObserverPattern\PlayerObserver;
use PHPUnit\Framework\TestCase;

/**
 * Class ObserverPatternTest.
 */
class ObserverPatternTest extends TestCase
{
    /**
     * @test
     */
    public function test_observer()
    {
        $this->expectOutputString(implode(array(
            "[Player A 收到通知] 有玩家加入了！",
            "[Player A 收到通知] 有玩家加入了！",
            "[Player B 收到通知] 有玩家加入了！",
            "[Player A 收到通知] 有玩家離開了！",
            "[Player C 收到通知] 有玩家離開了！",
        )));
        
        /**
         * 建立一個島嶼
         */
        $island = new Island();

        /**
         * Player A 加入了這座島嶼
         * 加入前島上沒有玩家
         * 所以沒有叮咚通知
         */
        $playerA = new PlayerObserver('Player A');
        $island->attach($playerA);

        /**
         * Player B 加入了這座島嶼
         * 加入前島上有 1 位玩家
         * 扣除自己後，會有 A 收到叮咚通知
         */
        $playerB = new PlayerObserver('Player B');
        $island->attach($playerB);

        /**
         * Player C 加入了這座島嶼
         * 加入前島上有 2 位玩家
         * 扣除自己後，會有 A、B 收到叮咚通知
         */
        $playerC = new PlayerObserver('Player C');
        $island->attach($playerC);

        /**
         * Island_B 離開了這座島嶼
         * 離開前島上有 3 位玩家
         * 扣除自己後，會有 A、C 收到叮咚通知
         */
        $island->detach($playerB);
    }
}

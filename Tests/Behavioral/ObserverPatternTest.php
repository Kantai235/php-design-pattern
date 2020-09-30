<?php

namespace Tests\Behavioral;

use DesignPatterns\Behavioral\ObserverPattern\User;
use DesignPatterns\Behavioral\ObserverPattern\UserObserver;
use DesignPatterns\Behavioral\ObserverPattern\Player;
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
        $observer = new PlayerObserver();

        $playerA = new Player('Island_A');
        $playerB = new Player('Island_B');
        $playerC = new Player('Island_C');

        $playerA->attach($observer);
        $playerB->attach($observer);
        $playerC->attach($observer);

        $playerA->join(); // [系統] Island_A 飛來了。
        $playerB->join(); // [系統] Island_B 飛來了。
        $playerC->join(); // [系統] Island_C 飛來了。

        $playerB->quit(); // [系統] Island_B 離開了。

        // $observer 應該要剩餘 2 位玩家
    }
}

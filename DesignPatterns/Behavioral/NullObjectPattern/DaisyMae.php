<?php

namespace DesignPatterns\Behavioral\NullObjectPattern;

/**
 * Class DaisyMae.
 */
class DaisyMae implements NPC
{
    /**
     * @param int $price
     * @param int $count
     */
    public function buyTurnips(int $price, int $count)
    {
        echo "[曹賣] 今天的價格是 1 棵 $price 鈴錢，要現在買嗎？";
    }

    /**
     * @param int $price
     * @param int $count
     */
    public function sellTurnips(int $price, int $count)
    {
        echo "[曹賣] 我是曹賣，你不能把大頭菜賣給我。";
    }
}

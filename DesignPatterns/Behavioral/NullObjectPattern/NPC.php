<?php

namespace DesignPatterns\Behavioral\NullObjectPattern;

/**
 * Interface NPC.
 */
interface NPC
{
    /**
     * @param int $price
     * @param int $count
     */
    public function buyTurnips(int $price, int $count);

    /**
     * @param int $price
     * @param int $count
     */
    public function sellTurnips(int $price, int $count);
}

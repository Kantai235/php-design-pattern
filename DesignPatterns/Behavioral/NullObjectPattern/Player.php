<?php

namespace DesignPatterns\Behavioral\NullObjectPattern;

/**
 * Class Player
 */
class Player
{
    /**
     * @var NPC
     */
    protected NPC $npc;

    /**
     * 
     * @param NPC $npc
     */
    public function __construct(NPC $npc)
    {
        $this->setNPC($npc);
    }

    /**
     * @param NPC $npc
     */
    public function setNPC(NPC $npc)
    {
        $this->npc = $npc;
    }

    /**
     * @param int $price
     * @param int $count
     */
    public function buy(int $price, int $count)
    {
        $this->npc->buyTurnips($price, $count);
    }

    /**
     * @param int $price
     * @param int $count
     */
    public function sell(int $price, int $count)
    {
        $this->npc->sellTurnips($price, $count);
    }
}

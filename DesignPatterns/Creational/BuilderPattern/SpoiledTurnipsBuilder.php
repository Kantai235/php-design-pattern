<?php

namespace DesignPatterns\Creational\BuilderPattern;

use DesignPatterns\Creational\BuilderPattern\Parts\SpoiledTurnips;

/**
 * Class SpoiledTurnipsBuilder.
 */
class SpoiledTurnipsBuilder implements BuilderContract
{
    /**
     * 壞掉的大頭菜是沒辦法賣鈴錢的狸！
     * 
     * @var int
     */
    const SPOILED_PRICE = 0;

    /**
     * @var SpoiledTurnips
     */
    protected SpoiledTurnips $turnips;

    /**
     * 
     */
    public function createTurnips()
    {
        $this->turnips = new SpoiledTurnips();
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price)
    {
        $this->turnips->setPrice($price);
    }

    /**
     * @param int $count
     */
    public function setCount(int $count)
    {
        $this->turnips->setCount(self::SPOILED_PRICE);
    }

    /**
     * @return SpoiledTurnips
     */
    public function getTurnips(): SpoiledTurnips
    {
        return $this->turnips;
    }
}

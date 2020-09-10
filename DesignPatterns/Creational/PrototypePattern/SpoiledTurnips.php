<?php

namespace DesignPatterns\Creational\PrototypePattern;

/**
 * Class SpoiledTurnips.
 */
class SpoiledTurnips extends TurnipsPrototype
{
    /**
     * @var string
     */
    protected $category = '壞掉的大頭菜';

    /**
     * 壞掉的大頭菜是沒辦法賣鈴錢的狸！
     * 
     * @var int
     */
    const SPOILED_PRICE = 0;

    /**
     * SpoiledTurnips constructor.
     *
     * @param int $price
     * @param int $count
     */
    public function __construct(int $price, int $count)
    {
        $this->price = self::SPOILED_PRICE;
        $this->count = $count;
    }

    /**
     * ...
     */
    public function __clone()
    {
        // TODO: Implement __Clone() method.
    }
}

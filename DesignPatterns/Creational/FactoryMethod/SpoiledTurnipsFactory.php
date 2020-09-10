<?php

namespace DesignPatterns\Creational\FactoryMethod;

/**
 * Class SpoiledTurnipsFactory.
 */
class SpoiledTurnipsFactory implements TurnipsFactoryContract
{
    /**
     * 壞掉的大頭菜是沒辦法賣鈴錢的狸！
     * 
     * @var int
     */
    const SPOILED_PRICE = 0;

    /**
     * @var int
     */
    protected $count;

    /**
     * SpoiledTurnipsFactory constructor.
     * 
     * @param int $count
     */
    public function __construct(int $count)
    {
        $this->count = $count;
    }

    /**
     * @return TurnipsContract
     */
    public function createTurnips(): TurnipsContract
    {
        return new SpoiledTurnips(self::SPOILED_PRICE, $this->count);
    }
}

<?php

namespace DesignPatterns\Creational\FactoryMethod;

/**
 * Class TurnipsFactory.
 */
class TurnipsFactory implements TurnipsFactoryContract
{
    /**
     * @var int
     */
    protected $price;

    /**
     * @var int
     */
    protected $count;

    /**
     * TurnipsFactory constructor.
     * 
     * @param int $price
     * @param int $count
     */
    public function __construct(int $price, int $count)
    {
        $this->price = $price;
        $this->count = $count;
    }

    /**
     * @return TurnipsContract
     */
    public function createTurnips(): TurnipsContract
    {
        return new Turnips($this->price, $this->count);
    }
}

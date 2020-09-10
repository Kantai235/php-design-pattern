<?php

namespace DesignPatterns\Structural\FlyweightPattern;

/**
 * Class TurnipsFlyweight.
 */
class TurnipsFlyweight implements FlyweightInterface
{
    /**
     * @var string
     */
    protected $island;

    /**
     * @var int
     */
    protected $price;

    /**
     * @var int
     */
    protected $count;

    /**
     * TurnipsFlyweight constructor.
     * 
     * @param string $island
     * @param int $price
     * @param int $count
     */
    public function __construct(string $island, int $price, int $count)
    {
        $this->island = $island;
        $this->price = $price;
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        return $this->price * $this->count;
    }
}

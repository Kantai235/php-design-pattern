<?php

namespace DesignPatterns\Structural\CompositePattern;

/**
 * Class PriceDown.
 */
class PriceDown implements TurnipsInterface
{
    /**
     * @var int
     */
    protected $price;

    /**
     * PriceDown constructor.
     *
     * @param int $price
     */
    public function __construct(int $price)
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        return - $this->price;
    }
}

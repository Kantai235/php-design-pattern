<?php

namespace DesignPatterns\Behavioral\SpecificationPattern;

/**
 * Class Turnips.
 */
class Turnips
{
    /**
     * @var int
     */
    protected int $price = 0;

    /**
     * @var int
     */
    protected int $count = 0;

    /**
     * Turnips constructor.
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
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }
}

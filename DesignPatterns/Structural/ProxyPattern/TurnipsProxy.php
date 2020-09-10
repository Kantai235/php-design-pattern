<?php

namespace DesignPatterns\Structural\ProxyPattern;

/**
 * Class TurnipsProxy.
 */
class TurnipsProxy extends Turnips implements TurnipsInterface
{
    /**
     * @var int
     */
    protected int $price = 0;

    /**
     * @var int
     */
    protected ?int $total = null;

    /**
     * TurnipsProxy constructor.
     * 
     * @param int $price
     * @param int $count
     */
    public function __construct(int $price, int $count)
    {
        $this->setPrice($price);
        $this->setCount($count);
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price)
    {
        $this->price = $price;
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
    public function calculateTotal(): int
    {
        if ($this->total === null)
        {
            $this->total = $this->getPrice() * $this->getCount();
        }

        return $this->total;
    }
}

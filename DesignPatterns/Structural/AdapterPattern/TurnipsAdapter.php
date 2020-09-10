<?php

namespace DesignPatterns\Structural\AdapterPattern;

/**
 * Class TurnipsAdapter.
 */
class TurnipsAdapter implements SpoiledInterface
{
    /**
     * @var TurnipsInterface
     */
    protected $turnips;

    /**
     * @param TurnipsInterface $turnips
     */
    public function __construct(TurnipsInterface $turnips)
    {
        $this->turnips = $turnips;
    }

    /**
     * @param int $pirce
     * 
     * @return int
     */
    public function risePrice(int $price): int
    {
        $this->turnips->setPrice(0);

        return $this->turnips->getPrice();
    }

    /**
     * @param int $price
     * 
     * @return int
     */
    public function fallPrice(int $price): int
    {
        $this->turnips->setPrice(0);

        return $this->turnips->getPrice();
    }

    /**
     * @param int $count
     * 
     * @return int
     */
    public function addCount(int $count): int
    {
        $this->turnips->addCount($count);

        return $this->count;
    }

    /**
     * @param int $count
     * 
     * @return int
     */
    public function subCount(int $count): int
    {
        $this->turnips->subCount($count);

        return $this->turnips->getCount();
    }

    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        if (isset($this->price) && isset($this->count)) {
            return 0 * $this->count;
        } else {
            return 0;
        }
    }
}

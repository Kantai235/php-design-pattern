<?php

namespace DesignPatterns\Structural\FacadePattern;

/**
 * Class Facade.
 */
class Facade
{
    /**
     * @var BagInterface
     */
    protected $bag;

    /**
     * @var StoreInterface
     */
    protected $store;

    /**
     * @var DaisyMaeInterface
     */
    protected $daisyMae;

    /**
     * Facade constructor.
     * 
     * @param BagInterface $bag
     * @param StoreInterface $store
     * @param DaisyMaeInterface $daisyMae
     */
    public function __construct(BagInterface $bag, StoreInterface $store, DaisyMaeInterface $daisyMae)
    {
        $this->bag = $bag;
        $this->store = $store;
        $this->daisyMae = $daisyMae;
    }

    /**
     * @param int $bells
     */
    public function takeupBells(int $bells): int
    {
        return $this->bag->setBells($bells);
    }

    /**
     * @param int $bells
     * 
     * @return int
     */
    public function takeoutBells(int $bells): int
    {
        return $this->bag->getBells($bells);
    }

    /**
     * @param int $price
     * @param int $count
     * 
     * @return int
     */
    public function buyTurnips(int $price, int $count): int
    {
        $this->bag->getBells($price * $count);
        $turnips = $this->daisyMae->buy($price, $count);
        $this->bag->setTurnips($turnips);

        return $this->bag->setBells(0);
    }

    /**
     * @param int $price
     * 
     * @return int
     */
    public function sellTurnips(int $price, int $count): int
    {
        $turnips = $this->bag->getTurnips($count);
        $bells = $this->store->sell($turnips, $price);
        return $this->bag->setBells($bells);
    }
}

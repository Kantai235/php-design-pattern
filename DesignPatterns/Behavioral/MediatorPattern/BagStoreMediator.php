<?php

namespace DesignPatterns\Behavioral\MediatorPattern;

/**
 * Class BagStoreMediator.
 */
class BagStoreMediator implements Mediator
{
    /**
     * @var Bag
     */
    protected Bag $bag;

    /**
     * @var Store
     */
    protected Store $store;

    /**
     * BagStoreMediator constructor.
     * 
     * @param Bag $bag
     * @param Store $store
     */
    public function __construct(Bag $bag, Store $store)
    {
        $this->bag = $bag;
        $this->store = $store;

        $this->bag->setMediator($this);
        $this->store->setMediator($this);
    }

    /**
     * @return int
     */
    public function getTurnips(): int
    {
        return $this->bag->getTurnips();
    }
    
    /**
     * @param int $count
     */
    public function setTurnips(int $count)
    {
        $this->bag->setTurnips($count);
    }

    /**
     * @return int
     */
    public function getBells(): int
    {
        return $this->bag->getBells();
    }

    /**
     * @param int $bells
     */
    public function setBells(int $bells)
    {
        $this->bag->setBells($bells);
    }
}
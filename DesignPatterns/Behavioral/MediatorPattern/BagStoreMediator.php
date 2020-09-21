<?php

namespace DesignPatterns\Behavioral\MediatorPattern;

use InvalidArgumentException;

/**
 * Class BagStoreMediator.
 */
class BagStoreMediator implements MediatorInterface
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
    public function getBells(): int
    {
        return $this->bag->getBells();
    }

    /**
     * @return int
     */
    public function getTurnips(): int
    {
        return $this->bag->getTurnips();
    }

    /**
     * @param int $bells
     */
    public function setBells(int $bells)
    {
        $this->bag->setBells($bells);
    }

    /**
     * @param int $count
     */
    public function setTurnips(int $count)
    {
        $this->bag->setTurnips($count);
    }

    /**
     * @param int $price
     * @param int $count
     * 
     * @throws InvalidArgumentException
     */
    public function buyTurnips(int $price, int $count)
    {
        $total = $price * $count;
        if ($this->bag->getBells() >= $total) {
            echo "[玩家] 您購買了 $count 顆大頭菜，每顆單價 $price 鈴錢，總共 $total 鈴錢。";
            $this->store->buyTurnips($price, $count);

            return;
        }

        throw new InvalidArgumentException('[錯誤] 您的大頭菜不足，無法購買大頭菜。');
    }

    /**
     * @param int $price
     * @param int $count
     * 
     * @throws InvalidArgumentException
     */
    public function sellTurnips(int $price, int $count)
    {
        $total = $price * $count;
        if ($this->bag->getTurnips() >= $count) {
            echo "[玩家] 您販賣了 $count 顆大頭菜，每顆單價 $price 鈴錢，總共 $total 鈴錢。";
            $this->store->sellTurnips($price, $count);

            return;
        }

        throw new InvalidArgumentException('[錯誤] 您的大頭菜不足，無法販賣大頭菜。');
    }
}

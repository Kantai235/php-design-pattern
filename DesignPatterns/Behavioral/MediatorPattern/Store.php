<?php

namespace DesignPatterns\Behavioral\MediatorPattern;

/**
 * Class Store.
 */
class Store extends Colleague
{
    /**
     * @param int $price
     * @param int $count
     */
    public function buyTurnips(int $price, int $count)
    {
        $total = $price * $count;
        if ($this->mediator->getBells() >= $total) {
            $bells = $this->mediator->getBells() - $total;
            $this->mediator->setBells($bells);
            $_count = $this->mediator->getTurnips() + $count;
            $this->mediator->setTurnips($_count);

            return;
        }

        throw new \InvalidArgumentException('您的大頭菜不足，無法購買大頭菜。');
    }

    /**
     * @param int $price
     * @param int $count
     */
    public function sellTurnips(int $price, int $count)
    {
        if ($this->mediator->getTurnips() >= $count) {
            $bells = $price * $count;
            $bells += $this->mediator->getBells();
            $_count = $this->mediator->getTurnips() - $count;
            $this->mediator->setTurnips($_count);

            return;
        }

        throw new \InvalidArgumentException('您的大頭菜不足，無法販賣大頭菜。');
    }
}

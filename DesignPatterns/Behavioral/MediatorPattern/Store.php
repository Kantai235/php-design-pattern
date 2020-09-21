<?php

namespace DesignPatterns\Behavioral\MediatorPattern;

use InvalidArgumentException;

/**
 * Class Store.
 */
class Store extends Colleague
{
    /**
     * @param int $price
     * @param int $count
     * 
     * @throws InvalidArgumentException
     * @return Turnips
     */
    public function buyTurnips(int $price, int $count)
    {
        $total = $price * $count;
        if ($this->mediator->getBells() >= $total) {
            /**
             * 跟商店(Store)買大頭菜(Turnips)，並且將大頭菜放入背包(Bag)當中。
             */
            $this->mediator->setBells($this->mediator->getBells() - $total);
            echo "[商店] 收到了 $total 鈴錢。";

            echo "[商店] 賣出了 $count 顆大頭菜。";
            $this->mediator->setTurnips($this->mediator->getTurnips() + $count);

            return;
        }

        throw new InvalidArgumentException('[錯誤] 您背包裡的鈴錢不足，無法購買大頭菜。');
    }

    /**
     * @param int $price
     * @param int $count
     * 
     * @throws InvalidArgumentException
     * @return int
     */
    public function sellTurnips(int $price, int $count)
    {
        if ($this->mediator->getTurnips() >= $count) {
            /**
             * 跟商店(Store)賣大頭菜(Turnips)，並且將鈴錢放入背包(Bag)當中。
             */
            $this->mediator->setTurnips($this->mediator->getTurnips() - $count);
            echo "[商店] 收購了 $count 顆大頭菜。";

            $total = $price * $count;
            echo "[商店] 支出了 $total 鈴錢。";
            $this->mediator->setBells($this->mediator->getBells() + $total);

            return;
        }

        throw new InvalidArgumentException('[錯誤] 您背包裡的大頭菜不足，無法販賣大頭菜。');
    }
}

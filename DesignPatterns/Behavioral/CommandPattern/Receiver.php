<?php

namespace DesignPatterns\Behavioral\CommandPattern;

/**
 * Class Receiver.
 */
class Receiver
{
    /**
     * @var int
     */
    protected int $turnips = 0;

    /**
     * @var int
     */
    protected int $bells = 0;

    /**
     * @param int $price
     * @param int $count
     */
    public function buy(int $price, int $count)
    {
        $total = $price * $count;
        if ($this->bells < $total) {
            throw new \InvalidArgumentException('您的鈴錢不足，無法購買大頭菜。');
        }

        $this->turnips += $count;
        $this->bells -= $total;
    }

    /**
     * @param int $price
     * @param int $count
     */
    public function sell(int $price, int $count)
    {
        if ($this->turnips < $count) {
            throw new \InvalidArgumentException('您的大頭菜不足，無法販賣大頭菜。');
        }

        $total = $price * $count;
        $this->turnips -= $count;
        $this->bells += $total;
    }

    /**
     * @param int $bells
     */
    public function setBells(int $bells)
    {
        $this->bells += $bells;
    }

    /**
     * @return int
     */
    public function getBells(): int
    {
        return $this->bells;
    }
}

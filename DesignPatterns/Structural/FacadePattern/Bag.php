<?php

namespace DesignPatterns\Structural\FacadePattern;

use InvalidArgumentException;

/**
 * Class Bag.
 */
class Bag implements BagInterface
{
    /**
     * @var int
     */
    protected $bells = 0;

    /**
     * @var Turnips
     */
    protected $turnips;

    /** 
     * @param int $bells
     */
    public function setBells(int $bells): int
    {
        $this->bells += $bells;

        return $this->bells;
    }

    /**
     * @throws InvalidArgumentException
     * @return int
     */
    public function getBells(int $bells): int
    {
        if ($this->bells >= $bells) {
            $this->bells -= $bells;
            return $this->bells;
        }

        throw new InvalidArgumentException('背包裡頭沒有那麼多的鈴錢。');
    }

    /** 
     * @param Turnips
     */
    public function setTurnips(Turnips $turnips): Turnips
    {
        $this->turnips = $turnips;

        return $this->turnips;
    }

    /**
     * @throws InvalidArgumentException
     * @return Turnips
     */
    public function getTurnips(int $count): Turnips
    {
        if ($this->turnips->getCount() >= $count) {
            $newCount = $this->turnips->getCount() - $count;
            $this->turnips->setCount($newCount);

            return new Turnips($this->turnips->getPrice(), $count);
        }

        throw new InvalidArgumentException('背包裡頭沒有那麼多的大頭菜。');
    }
}

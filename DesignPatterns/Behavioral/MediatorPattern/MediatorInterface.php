<?php

namespace DesignPatterns\Behavioral\MediatorPattern;

/**
 * Interface MediatorInterface.
 */
interface MediatorInterface
{
    /**
     * @return int
     */
    public function getBells(): int;

    /**
     * @return int
     */
    public function getTurnips(): int;

    /**
     * @param int $bells
     */
    public function setBells(int $bells);
    
    /**
     * @param int $count
     */
    public function setTurnips(int $count);

    /**
     * @param int $price
     * @param int $count
     */
    public function buyTurnips(int $price, int $count);

    /**
     * @param int $price
     * @param int $count
     */
    public function sellTurnips(int $price, int $count);
}

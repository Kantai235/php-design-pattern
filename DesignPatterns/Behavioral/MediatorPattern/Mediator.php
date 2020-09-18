<?php

namespace DesignPatterns\Behavioral\MediatorPattern;

/**
 * Interface Mediator.
 */
interface Mediator
{
    /**
     * @return int
     */
    public function getTurnips(): int;
    
    /**
     * @param int $count
     */
    public function setTurnips(int $count);

    /**
     * @return int
     */
    public function getBells(): int;

    /**
     * @param int $bells
     */
    public function setBells(int $bells);
}
<?php

namespace DesignPatterns\Structural\ProxyPattern;

/**
 * Interface TurnipsInterface.
 */
interface TurnipsInterface
{
    /**
     * @param int $count
     */
    public function setCount(int $count);

    /**
     * @return int
     */
    public function getCount(): int;
}
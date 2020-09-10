<?php

namespace DesignPatterns\Structural\AdapterPattern;

/**
 * Interface SpoiledInterface.
 */
interface SpoiledInterface
{
    public function risePrice(int $price): int;

    public function fallPrice(int $price): int;

    public function addCount(int $count): int;

    public function subCount(int $count): int;
    
    public function calculatePrice(): int;
}

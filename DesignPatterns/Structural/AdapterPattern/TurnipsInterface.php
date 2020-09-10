<?php

namespace DesignPatterns\Structural\AdapterPattern;

/**
 * Interface TurnipsInterface.
 */
interface TurnipsInterface
{
    public function risePrice(int $price): int;

    public function fallPrice(int $price): int;

    public function getPrice(): int;

    public function setPrice(int $price): int;

    public function addCount(int $count): int;

    public function subCount(int $count): int;

    public function getCount(): int;

    public function setCount(int $count): int;

    public function calculatePrice(): int;
}

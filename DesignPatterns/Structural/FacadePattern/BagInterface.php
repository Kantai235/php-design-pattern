<?php

namespace DesignPatterns\Structural\FacadePattern;

/**
 * Interface BagInterface.
 */
interface BagInterface
{
    /** 
     * @param int $bells
     */
    public function setBells(int $bells): int;

    /** 
     * @return int
     */
    public function getBells(int $bells): int;

    /** 
     * @param Turnips $turnips
     */
    public function setTurnips(Turnips $turnips): Turnips;

    /** 
     * @return Turnips
     */
    public function getTurnips(int $count): Turnips;
}

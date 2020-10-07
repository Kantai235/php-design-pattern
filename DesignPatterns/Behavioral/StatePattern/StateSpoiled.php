<?php

namespace DesignPatterns\Behavioral\StatePattern;

/**
 * Class StateSpoiled.
 */
class StateSpoiled implements State
{
    /**
     * @param Turnips $turnips
     */
    public function proceedToNext(Turnips $turnips)
    {
        // there is nothing more to do
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return 'spoiled';
    }
}

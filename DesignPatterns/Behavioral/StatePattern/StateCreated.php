<?php

namespace DesignPatterns\Behavioral\StatePattern;

/**
 * Class StateCreated.
 */
class StateCreated implements State
{
    /**
     * @param Turnips $turnips
     */
    public function proceedToNext(Turnips $turnips)
    {
        $turnips->setState(new StateSpoiled());
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return 'created';
    }
}

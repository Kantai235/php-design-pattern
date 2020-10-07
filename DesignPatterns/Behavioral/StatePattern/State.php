<?php

namespace DesignPatterns\Behavioral\StatePattern;

/**
 * Interface State.
 */
interface State
{
    /**
     * @param Turnips $turnips
     */
    public function proceedToNext(Turnips $turnips);

    /**
     * @return string
     */
    public function toString(): string;
}

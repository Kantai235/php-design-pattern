<?php

namespace DesignPatterns\Behavioral\StatePattern;

/**
 * Class Turnips.
 */
class Turnips
{
    /**
     * @var State
     */
    protected State $state;

    /**
     * @var int
     */
    protected int $price;

    /**
     * @var int
     */
    protected int $count;

    /**
     * Turnips constructor.
     * 
     * @param int $price
     * @param int $count
     */
    public function __construct(int $price, int $count)
    {
        $this->price = $price;
        $this->count = $count;
    }

    /**
     * @return Turnips
     */
    public static function create(int $price, int $count): Turnips
    {
        $turnips = new self($price, $count);
        $turnips->state = new StateCreated();

        return $turnips;
    }

    /**
     * @param State $state
     */
    public function setState(State $state)
    {
        $this->state = $state;
    }

    /**
     * @return void
     */
    public function proceedToNext()
    {
        $this->state->proceedToNext($this);
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->state->toString();
    }

    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        switch ($this->toString()) {
            case 'created':
                return $this->price * $this->count;

            case 'spoiled':
                return 0;
        }
    }
}

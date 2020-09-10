<?php

namespace DesignPatterns\Structural\DataMapper;

/**
 * Class Turnips.
 */
class Turnips
{
    /**
     * @var string
     */
    protected $island;

    /**
     * @var int
     */
    protected $price;

    /**
     * @var int
     */
    protected $count;

    /**
     * Turnips constructor.
     *
     * @param string $island
     * @param int    $price
     * @param int    $count
     */
    public function __construct(string $island, int $price, int $count)
    {
        $this->island = $island;
        $this->price = $price;
        $this->count = $count;
    }

    /**
     * @param array $island
     * 
     * @return Turnips
     */
    public static function fromIsland(array $island): Turnips
    {
        return new self(
            $island['island'],
            $island['price'],
            $island['count']
        );
    }
}

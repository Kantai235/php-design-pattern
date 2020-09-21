<?php

namespace DesignPatterns\Structural\DependencyInjection;

use InvalidArgumentException;

/**
 * Class TurnipsConfiguration.
 */
class TurnipsConfiguration
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var int
     */
    protected $price;

    /**
     * @var int
     */
    protected $count;

    /**
     * TurnipsConfiguration constructor.
     * 
     * @param string $type
     * @param int $price
     * @param int $count
     * 
     * @throws InvalidArgumentException
     */
    public function __construct(string $type, int $price, int $count)
    {
        $this->type = $type;

        switch ($type) {
            case '健康的大頭菜':
                $this->price = $price;
                $this->count = $count;
                break;

            case '壞掉的大頭菜':
                $this->price = 0;
                $this->count = $count;
                break;
    
            default:
                throw new InvalidArgumentException('找不到這種大頭菜分類。');
        }
    }

    /**
     * @return int
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }
}

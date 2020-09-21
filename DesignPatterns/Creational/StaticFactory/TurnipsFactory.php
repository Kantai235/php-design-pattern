<?php

namespace DesignPatterns\Creational\StaticFactory;

use InvalidArgumentException;

/**
 * Class TurnipsFactory.
 */
final class TurnipsFactory
{
    /**
     * @param string $type
     * @param int    $price
     * @param int    $count
     *
     * @throws InvalidArgumentException
     * @return TurnipsContract
     */
    public static function factory(string $type, int $price, int $count): TurnipsContract
    {
        if ($type === '大頭菜') {
            return new Turnips($price, $count);
        }

        if ($type === '壞掉的大頭菜') {
            return new SpoiledTurnips($price, $count);
        }

        throw new InvalidArgumentException('找不到這種大頭菜分類。');
    }
}

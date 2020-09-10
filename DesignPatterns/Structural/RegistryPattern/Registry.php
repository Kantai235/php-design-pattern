<?php

namespace DesignPatterns\Structural\RegistryPattern;

use InvalidArgumentException;

/**
 * Abstract Registry.
 */
abstract class Registry
{
    /**
     * @var Turnips[]
     */
    protected static array $turnips = [];

    /**
     * @param
     * 
     * @throws InvalidArgumentException
     * @return Turnips|null
     */
    public static function findTurnipsByIsland(string $island)
    {
        foreach (self::$turnips as $turnip) {
            if ($island === $turnip->getIsland()) {
                return $turnip;
            }
        }

        throw new InvalidArgumentException('大頭菜儲存容器找不到目標。');
    }

    /**
     * @param
     * 
     * @throws InvalidArgumentException
     * @return Turnips|null
     */
    public static function findIndexByIsland(string $island)
    {
        foreach (self::$turnips as $index => $turnip) {
            if ($island === $turnip->getIsland()) {
                return $index;
            }
        }

        return null;
    }

    /**
     * @param string  $island
     * @param Turnips $turnip
     * 
     * @throws InvalidArgumentException
     */
    public static function store(Turnips $turnips)
    {
        if (self::findIndexByIsland($turnips->getIsland())) {
            throw new InvalidArgumentException('大頭菜儲存容器已經包含這顆大頭菜了。');
        }

        array_push(self::$turnips, $turnips);
    }

    /**
     * @param Turnips $turnip
     * 
     * @throws InvalidArgumentException
     */
    public static function update(Turnips $turnips)
    {
        if ($index = self::findIndexByIsland($turnips->getIsland())) {
            self::$turnips[$index]->setPrice($turnips->getPrice());
            self::$turnips[$index]->setCount($turnips->getCount());

            return;
        }

        throw new InvalidArgumentException('大頭菜儲存容器找不到目標。');
    }

    /**
     * @param string  $island
     * @param Turnips $turnip
     * 
     * @throws InvalidArgumentException
     */
    public static function destroy(Turnips $turnips)
    {
        if ($index = self::findIndexByIsland($turnips->getIsland())) {
            unset(self::$turnips[$index]);
            
            return;
        }

        throw new InvalidArgumentException('大頭菜儲存容器找不到目標。');
    }
}

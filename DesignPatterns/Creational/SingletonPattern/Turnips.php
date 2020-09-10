<?php

namespace DesignPatterns\Creational\SingletonPattern;

/**
 * Class Turnips.
 */
final class Turnips
{
    /**
     * @var Turnips
     */
    protected static $turnips;

    /**
     * 透過延遲載入的方式來取得大頭菜
     * 
     * @return Turnips
     */
    public static function getTurnips(): Turnips
    {
        if (static::$turnips === null) {
            static::$turnips = new static();
        }

        return static::$turnips;
    }

    /**
     * 不允許自己生產大頭菜，你必須去跟曹賣買
     * 為了防止玩家自己生產大頭菜，必須透過 Turnips::getTurnips() 方法來取得大頭菜
     */
    private function __construct()
    {
        // ...
    }

    /**
     * 防止大頭菜被玩家複製
     */
    private function __clone()
    {
        // ...
    }

    /**
     * 防止大頭菜被反序列化，這個過程會建立大頭菜的副本
     */
    private function __wakeup()
    {
        // ...
    }
}

<?php

namespace Tests\Creational;

use DesignPatterns\Creational\SingletonPattern\Turnips;
use PHPUnit\Framework\TestCase;

/**
 * Class SingletonPatternTest.
 */
class SingletonPatternTest extends TestCase
{
    /**
     * 建立兩個大頭菜，比較兩個是否都是大頭菜，而且兩個大頭菜都是一模一樣的東西。
     * 
     * @test
     */
    public function test_uniqueness()
    {
        $turnipsA = Turnips::getTurnips();
        $turnipsB = Turnips::getTurnips();

        $this->assertInstanceOf(Turnips::class, $turnipsA);
        $this->assertInstanceOf(Turnips::class, $turnipsB);
        $this->assertSame($turnipsA, $turnipsB);
    }
}

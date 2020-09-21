<?php

namespace Tests\Structural;

use DesignPatterns\Structural\RegistryPattern\Registry;
use DesignPatterns\Structural\RegistryPattern\Turnips;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Class RegistryPatternTest.
 */
class RegistryPatternTest extends TestCase
{
    /**
     * 測試是否能夠建立大頭菜，放入後並取出是稍早建立的大頭菜。
     * 
     * @test
     */
    public function test_registry_store()
    {
        $turnips = new Turnips('Island_A', 100, 40);
        Registry::store($turnips);

        $this->assertSame($turnips, Registry::findTurnipsByIsland('Island_A'));
    }

    /**
     * 測試連續建立重複的大頭菜是否會獲得錯誤。
     * 
     * @test
     */
    public function test_registry_store_exception()
    {
        $this->expectException(InvalidArgumentException::class);

        $turnips = new Turnips('Island_B', 100, 40);
        Registry::store($turnips);
        Registry::store($turnips);
    }

    /**
     * 測試直接獲取不存在的大頭菜索引是否會獲得空值。
     * 
     * @test
     */
    public function test_registry_get_exception()
    {
        $this->assertNull(Registry::findIndexByIsland('Island_Null'));
    }

    /**
     * 測試建立大頭菜並更新大頭菜之後，大頭菜資訊是否有正確更新。
     * 
     * @test
     */
    public function test_registry_update()
    {
        $turnips = new Turnips('Island_C', 100, 40);
        Registry::store($turnips);

        $turnips->setPrice(90);
        $turnips->setCount(20);
        Registry::update($turnips);

        $this->assertSame($turnips, Registry::findTurnipsByIsland('Island_C'));
    }

    /**
     * 測試大頭菜是否能夠被移除。
     * 
     * @test
     */
    public function test_registry_destroy()
    {
        $turnips = new Turnips('Island_D', 100, 40);
        Registry::store($turnips);
        $this->assertSame($turnips, Registry::findTurnipsByIsland('Island_D'));

        $this->expectException(InvalidArgumentException::class);
        Registry::destroy($turnips);
        Registry::findTurnipsByIsland('Island_D');
    }
}

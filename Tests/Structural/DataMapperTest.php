<?php

namespace Tests\Structural;

use DesignPatterns\Structural\DataMapper\StorageAdapter;
use DesignPatterns\Structural\DataMapper\Turnips;
use DesignPatterns\Structural\DataMapper\TurnipsMapper;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Class DataMapperTest.
 */
class DataMapperTest extends TestCase
{
    /**
     * 測試塞入大頭菜列，並且取得 id 為 1 的大頭菜。
     * 
     * @test
     */
    public function test_can_map_turnips_from_storage()
    {
        $storage = new StorageAdapter(
            array(
                1 => array(
                    'island' => 'kantai',
                    'price' => 100,
                    'count' => 40,
                ),
            ),
        );

        $mapper = new TurnipsMapper($storage);

        $turnips = $mapper->findById(1);

        $this->assertInstanceOf(Turnips::class, $turnips);
    }

    /**
     * 測試塞入空的大頭菜列，並且成功獲得例外錯誤。
     * 
     * @test
     */
    public function test_will_not_map_invalid_data()
    {
        $this->expectException(InvalidArgumentException::class);

        $storage = new StorageAdapter([]);
        $mapper = new TurnipsMapper($storage);

        $mapper->findById(1);
    }
}

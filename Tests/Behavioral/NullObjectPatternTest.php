<?php

namespace Tests\Behavioral;

use DesignPatterns\Behavioral\NullObjectPattern\DaisyMae;
use DesignPatterns\Behavioral\NullObjectPattern\Mamekichi;
use DesignPatterns\Behavioral\NullObjectPattern\Player;
use DesignPatterns\Behavioral\NullObjectPattern\Tsubukichi;
use PHPUnit\Framework\TestCase;

/**
 * Class NullObjectPatternTest.
 */
class NullObjectPatternTest extends TestCase
{
    /**
     * @test
     */
    public function test_daisy_mas()
    {
        $this->expectOutputString(implode(array(
            "[曹賣] 今天的價格是 1 棵 100 鈴錢，要現在買嗎？",
            "[曹賣] 我是曹賣，你不能把大頭菜賣給我。",
        )));
        
        $player = new Player(new DaisyMae());
        $player->buy(100, 40);
        $player->sell(200, 40);
    }

    /**
     * @test
     */
    public function test_mamekichi()
    {
        $this->expectOutputString(implode(array(
            "[豆狸] 我是豆狸，我沒有在賣大頭菜狸。",
            "[粒狸] 沒有在賣。",
            "[豆狸] 現在的大頭菜價格是 1 棵 200 鈴錢！",
            "[粒狸] 鈴錢！",
            "[豆狸] 好了！那麼，一共是 8000 鈴錢，確定要賣掉嗎？[粒狸] 賣掉嗎？",
        )));

        $player = new Player(new Mamekichi());
        $player->buy(100, 40);
        $player->sell(200, 40);
    }

    /**
     * @test
     */
    public function test_tsubukichi()
    {
        $this->expectOutputString(implode(array(
            "[粒狸] 我是粒狸，我沒有在賣大頭菜狸。",
            "[豆狸] 沒有在賣。",
            "[粒狸] 現在的大頭菜價格是 1 棵 200 鈴錢！",
            "[豆狸] 鈴錢！",
            "[粒狸] 好了！那麼，一共是 8000 鈴錢，確定要賣掉嗎？",
            "[豆狸] 賣掉嗎？",
        )));

        $player = new Player(new Tsubukichi());
        $player->buy(100, 40);
        $player->sell(200, 40);
    }

    /**
     * @test
     */
    public function test_daisy_mas_buy_and_mamekichi_and_tsubukichi()
    {
        $this->expectOutputString(implode(array(
            "[曹賣] 今天的價格是 1 棵 100 鈴錢，要現在買嗎？",
            "[豆狸] 現在的大頭菜價格是 1 棵 200 鈴錢！",
            "[粒狸] 鈴錢！",
            "[豆狸] 好了！那麼，一共是 4000 鈴錢，確定要賣掉嗎？",
            "[粒狸] 賣掉嗎？",
            "[粒狸] 現在的大頭菜價格是 1 棵 300 鈴錢！",
            "[豆狸] 鈴錢！",
            "[粒狸] 好了！那麼，一共是 6000 鈴錢，確定要賣掉嗎？",
            "[豆狸] 賣掉嗎？",
        )));

        $player = new Player(new DaisyMae());
        $player->buy(100, 40);
        $player->setNPC(new Mamekichi());
        $player->sell(200, 20);
        $player->setNPC(new Tsubukichi());
        $player->sell(300, 20);
    }
}

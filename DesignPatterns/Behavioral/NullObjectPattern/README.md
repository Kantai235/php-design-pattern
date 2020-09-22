![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/NullObjectPattern/Banner.png)

# 空物件模式 Null Object Pattern
空物件模式，一種以非 Null 的空白物件去取代 Null 的模式，其空白物件並不是拿來比對資料是否為 Null，而是讓原本應該做些事情的物件，因為空白物件而不做任何事，或是去執行預設的動作，打個比喻來說，遊戲裡面購買、販賣大頭菜是要找不同 NPC 的，如果要購買大頭菜，那就必須找曹賣(Daisy Mae)來購買，如果要販賣大頭菜則是找豆狸粒狸(Mamekichi and Tsubukichi)來販賣。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/NullObjectPattern/UML.png)

## 實作
玩家要購買、販賣大頭菜會跟 NPC 進行這些動作，所以我們要先定義 NPC 所能提供的功能有哪些，因此會有購買大頭菜、販賣大頭菜這兩個方法被定義出來，如果繼承了 NPC 這個介面就要去實作這兩個方法。

NPC.php
```php
/**
 * Interface NPC.
 */
interface NPC
{
    /**
     * @param int $price
     * @param int $count
     */
    public function buyTurnips(int $price, int $count);

    /**
     * @param int $price
     * @param int $count
     */
    public function sellTurnips(int $price, int $count);
}
```

接下來實作曹賣(Daisy Mae)，但曹賣本身就只能購買大頭菜，因此在購買大頭菜的方法上實作這件事，但在販賣大頭菜的部分則是可以撰寫些對應的處理流程，這邊舉例為曹賣的貼心告知。

DaisyMae.php
```php
/**
 * Class DaisyMae.
 */
class DaisyMae implements NPC
{
    /**
     * @param int $price
     * @param int $count
     */
    public function buyTurnips(int $price, int $count)
    {
        echo "[曹賣] 今天的價格是 1 棵 $price 鈴錢，要現在買嗎？";
    }

    /**
     * @param int $price
     * @param int $count
     */
    public function sellTurnips(int $price, int $count)
    {
        echo "[曹賣] 我是曹賣，你不能把大頭菜賣給我。";
    }
}
```

曹賣(DaisyMae)是負責提供玩家可以購買大頭菜的重要 NPC，因此接下來要撰寫豆狸(Mamekichi)以及粒狸(Tsubukichi)兩位負責提供玩家販賣大頭菜的重要 NPC。

Mamekichi.php
```php
/**
 * Class Mamekichi.
 */
class Mamekichi implements NPC
{
    /**
     * @param int $price
     * @param int $count
     */
    public function buyTurnips(int $price, int $count)
    {
        echo "[豆狸] 我是豆狸，我沒有在賣大頭菜狸。";
        echo "[粒狸] 沒有在賣。";
    }

    /**
     * @param int $price
     * @param int $count
     */
    public function sellTurnips(int $price, int $count)
    {
        $total = $price * $count;
        echo "[豆狸] 現在的大頭菜價格是 1 棵 $price 鈴錢！";
        echo "[粒狸] 鈴錢！";
        echo "[豆狸] 好了！那麼，一共是 $total 鈴錢，確定要賣掉嗎？";
        echo "[粒狸] 賣掉嗎？";
    }
}
```

Tsubukichi.php
```php
/**
 * Class Tsubukichi.
 */
class Tsubukichi implements NPC
{
    /**
     * @param int $price
     * @param int $count
     */
    public function buyTurnips(int $price, int $count)
    {
        echo "[粒狸] 我是粒狸，我沒有在賣大頭菜狸。";
        echo "[豆狸] 沒有在賣。";
    }

    /**
     * @param int $price
     * @param int $count
     */
    public function sellTurnips(int $price, int $count)
    {
        $total = $price * $count;
        echo "[粒狸] 現在的大頭菜價格是 1 棵 $price 鈴錢！";
        echo "[豆狸] 鈴錢！";
        echo "[粒狸] 好了！那麼，一共是 $total 鈴錢，確定要賣掉嗎？";
        echo "[豆狸] 賣掉嗎？";
    }
}
```

最後我們要模擬玩家(Player)出來，並且帶入當前目標 NPC 物件，假想為玩家目前正在對話的目標，並且有兩個行為，分別是購買大頭菜、販賣大頭菜的動作。

Player.php
```php
/**
 * Class Player
 */
class Player
{
    /**
     * @var NPC
     */
    protected NPC $npc;

    /**
     * 
     * @param NPC $npc
     */
    public function __construct(NPC $npc)
    {
        $this->setNPC($npc);
    }

    /**
     * @param NPC $npc
     */
    public function setNPC(NPC $npc)
    {
        $this->npc = $npc;
    }

    /**
     * @param int $price
     * @param int $count
     */
    public function buy(int $price, int $count)
    {
        $this->npc->buyTurnips($price, $count);
    }

    /**
     * @param int $price
     * @param int $count
     */
    public function sell(int $price, int $count)
    {
        $this->npc->sellTurnips($price, $count);
    }
}
```

## 測試
最後我們要測試空物件模式的幾個需要做的事情，首先是測試在無法提供特定功能下，其物件是否會執行預設給予的行為動作，像是曹賣僅提供購買大頭菜的功能，但不提供販賣大頭菜的功能，如果玩家對曹賣執行販賣大頭菜的功能，那麼曹賣會告訴玩家這項動作無法執行。
1. 測試曹賣執行購買、販賣大頭菜的動作。
2. 測試豆狸執行購買、販賣大頭菜的動作。
3. 測試粒狸執行購買、販賣大頭菜的動作。
4. 測試對曹賣購買大頭菜，並切換 NPC 目標，向豆狸、粒狸販賣大頭菜。

NullObjectPatternTest.php
```php
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
```

最後測試的執行結果會獲得如下：

```
PHPUnit Pretty Result Printer 0.28.0 by Codedungeon and contributors.
==> Configuration: ~/php-design-pattern/vendor/codedungeon/phpunit-result-printer/src/phpunit-printer.yml

PHPUnit 9.2.6 by Sebastian Bergmann and contributors.


 ==> ...fResponsibilitiesTest   ✔  ✔  ✔  
 ==> CommandPatternTest         ✔  
 ==> IteratorPatternTest        ✔  ✔  ✔  ✔  
 ==> MediatorPatternTest        ✔  ✔  ✔  
 ==> MementoPatternTest         ✔  
 ==> NullObjectPatternTest      ✔  ✔  ✔  ✔  
 ==> AbstractFactoryTest        ✔  ✔  ✔  ✔  
 ==> BuilderPatternTest         ✔  ✔  ✔  ✔  
 ==> FactoryMethodTest          ✔  ✔  ✔  ✔  
 ==> PoolPatternTest            ✔  ✔  
 ==> PrototypePatternTest       ✔  ✔  
 ==> SimpleFactoryTest          ✔  ✔  ✔  ✔  
 ==> SingletonPatternTest       ✔  
 ==> StaticFactoryTest          ✔  ✔  ✔  ✔  ✔  
 ==> AdapterPatternTest         ✔  ✔  
 ==> BridgePatternTest          ✔  ✔  ✔  
 ==> CompositePatternTest       ✔  ✔  ✔  
 ==> DataMapperTest             ✔  ✔  
 ==> DecoratorPatternTest       ✔  ✔  
 ==> DependencyInjectionTest    ✔  ✔  ✔  
 ==> FacadePatternTest          ✔  
 ==> FluentInterfaceTest        ✔  
 ==> FlyweightPatternTest       ✔  
 ==> ProxyPatternTest           ✔  ✔  
 ==> RegistryPatternTest        ✔  ✔  ✔  ✔  ✔  

Time: 00:00.042, Memory: 8.00 MB

OK (67 tests, 136 assertions)
```

## 完整程式碼
[設計模式不難，找回快樂而已，以大頭菜為例。](https://github.com/Kantai235/php-design-pattern)
- [技術部落格文章 - 空物件模式](https://kantai235.github.io/NullObjectPattern)
- [空物件模式 原始碼](https://github.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/NullObjectPattern)
- [空物件模式 測試](https://github.com/Kantai235/php-design-pattern/master/Tests/Behavioral/NullObjectPatternTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

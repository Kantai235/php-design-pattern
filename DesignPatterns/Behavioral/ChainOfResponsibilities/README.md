![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/ChainOfResponsibilities/Banner.png)

# 責任鏈模式 Chain of Responsibilities
責任鏈模式，有一系列的命令物件及處理物件，常見於需要被連續處理的地方上，舉例來說，假設今天收購箱、商店收購大頭菜時，多了一些條件，你必須先把大頭菜拿去收購箱收購，並且收購箱子會有鈴錢價格打 8 折的情形，剩下有多餘的大頭菜才能拿去給商店收購。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/ChainOfResponsibilities/UML.png)

## 實作
首先我們要先把背包(Bag)、大頭菜(Turnips)這兩個東西給實作出來，先從大頭菜開始，一樣建立簡單的鈴錢、數量以及獲取賦予方法。

Turnips.php
```php
/**
 * Class Turnips.
 */
class Turnips
{
    /**
     * @var int
     */
    protected int $price;

    /**
     * @var int
     */
    protected int $count;

    /**
     * Turnips constructor.
     * 
     * @param int $price
     * @param int $count
     */
    public function __construct(int $price, int $count)
    {
        $this->setPrice($price);
        $this->setCount($count);
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price)
    {
        $this->price = $price;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count)
    {
        $this->count = $count;
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
```

再來要建立背包(Bag)這個物件，裡面主要會放置兩個主要的物件，分別是大頭菜($turnips: Turnips)以及鈴錢($bells: int)，並且擁有簡單的取得(get)及賦予(set)方法。

Bag.php
```php
/**
 * Class Bag.
 */
class Bag
{
    /**
     * @var Turnips
     */
    protected Turnips $turnips;

    /**
     * @var int
     */
    protected int $bells = 0;

    /**
     * @param Turnips $turnips
     */
    public function setTurnips(Turnips $turnips)
    {
        $this->turnips = $turnips;
    }

    /**
     * @param int $bells
     */
    public function setBells(int $bells)
    {
        $this->bells = $bells;
    }

    /**
     * @return Turnips
     */
    public function getTurnips(): Turnips
    {
        return $this->turnips;
    }

    /**
     * @return int
     */
    public function getBells(): int
    {
        return $this->bells;
    }
}
```

再來我們要建立主要的處理物件(Handler)，這個處理物件是抽象介面，主要先實作出上層的處理物件是什麼，其次需要繼承的子類別需要實作賣大頭菜的方法。

Handler.php
```php
/**
 * Abstract Handler.
 */
abstract class Handler
{
    /**
     * @var Handler
     */
    protected $upper;

    /**
     * @param Handler $upper
     */
    public function setUpperHandler(Handler $upper)
    {
        $this->upper = $upper;
    }

    /**
     * @param Bag $bag
     */
    abstract public function sellTurnips(Bag $bag): Bag;
}
```

最後我們要建立收購箱(Box)的處理物件，以及商店(Store)的處理物件，收購箱最多只能賣 20 顆大頭菜，並且收購價格都會打 8 折，如果背包裡有剩餘的大頭菜，那麼收購箱就會去呼叫上層處理物件去處理剩下的大頭菜，而在這邊收購箱(Box)的上層物件就會是商店(Store)。

BoxHandler.php
```php
/**
 * Class BoxHandler.
 */
class BoxHandler extends Handler
{
    /**
     * @param Bag $bag
     */
    public function sellTurnips(Bag $bag): Bag
    {
        $bells = function(int $oldBells, int $price, int $count) {
            $_bells = ($price * $count) * 0.8;
            $_bells += $oldBells;
            return $_bells;
        };

        if ($bag->getTurnips()->getCount() >= 20) {
            $newBells = $bells($bag->getBells(), $bag->getTurnips()->getPrice(), 20);
            $bag->setBells($newBells);
            $bag->getTurnips()->setCount($bag->getTurnips()->getCount() - 20);

            return $this->upper->sellTurnips($bag);
        }

        $newBells = $bells($bag->getBells(), $bag->getTurnips()->getPrice(), $bag->getTurnips()->getCount());
        $bag->setBells($newBells);
        $bag->getTurnips()->setCount(0);

        return $bag;
    }
}
```

StoreHandler.php
```php
/**
 * Class StoreHandler.
 */
class StoreHandler extends Handler
{
    /**
     * @param Bag $bag
     */
    public function sellTurnips(Bag $bag): Bag
    {
        $bells = $bag->getTurnips()->getPrice() * $bag->getTurnips()->getCount();
        $bells += $bag->getBells();
        $bag->getTurnips()->setCount(0);
        $bag->setBells($bells);

        return $bag;
    }
}
```

## 測試
最後我們要來進行一連串的測試，來測試大頭菜責任鏈模式是否可以正常運作，所以會有幾些測試項目需要執行：
1. 測試一次賣 40 顆大頭菜，是否會有 20 顆大頭菜在商店被賣出。
2. 測試一次賣 20 顆大頭菜，是否全部的大頭菜都只會在收購箱被賣出。
3. 測試賣兩次大頭菜，所賣出的鈴錢是否正確。

```php
/**
 * Class ChainOfResponsibilitiesTest.
 */
class ChainOfResponsibilitiesTest extends TestCase
{
    /**
     * @var Bag
     */
    protected $bag;

    /**
     * @var Handler
     */
    protected $handler;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        /**
         * 設定背包。
         */
        $this->bag = new Bag();

        /**
         * 設定收購箱、商店。
         */
        $this->handler = new BoxHandler();
        $storeHandler = new StoreHandler();
        $this->handler->setUpperHandler($storeHandler);
    }

    /**
     * 測試一次賣 40 顆大頭菜，是否會有 20 顆大頭菜在商店被賣出。
     * 
     * @test
     */
    public function test_sell_turnips_to_store()
    {
        $this->bag->setTurnips(new Turnips(100, 40));
        $this->bag = $this->handler->sellTurnips($this->bag);
        $this->assertEquals(3600, $this->bag->getBells());
    }

    /**
     * 測試一次賣 20 顆大頭菜，是否全部的大頭菜都只會在收購箱被賣出。
     * 
     * @test
     */
    public function test_sell_turnips_to_box()
    {
        $this->bag->setTurnips(new Turnips(80, 20));
        $this->bag = $this->handler->sellTurnips($this->bag);
        $this->assertEquals(1280, $this->bag->getBells());
    }

    /**
     * 測試賣兩次大頭菜，所賣出的鈴錢是否正確。
     * 
     * @test
     */
    public function test_sell_turnips_to_box_and_store()
    {
        $this->bag->setTurnips(new Turnips(80, 20));
        $this->bag = $this->handler->sellTurnips($this->bag);
        $this->assertEquals(1280, $this->bag->getBells());

        $this->bag->setTurnips(new Turnips(100, 60));
        $this->bag = $this->handler->sellTurnips($this->bag);
        $this->assertEquals(6880, $this->bag->getBells());
    }
}
```

最後測試的執行結果會獲得如下：

```
 ==> ...fResponsibilitiesTest   ✔  ✔  ✔  
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

Time: 00:00.066, Memory: 6.00 MB

OK (54 tests, 120 assertions)
```

## 完整程式碼
[設計模式不難，找回快樂而已，以大頭菜為例。](https://github.com/Kantai235/php-design-pattern)
- [技術部落格文章 - 責任鏈模式](https://kantai235.github.io/ChainOfResponsibilities)
- [責任鏈模式 原始碼](https://github.com/Kantai235/php-design-pattern/tree/master/DesignPatterns/Behavioral/ChainOfResponsibilities)
- [責任鏈模式 測試](https://github.com/Kantai235/php-design-pattern/tree/master/Tests/Behavioral/ChainOfResponsibilitiesTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

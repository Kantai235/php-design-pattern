![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Structural/AdapterPattern/Banner.png)

# 轉接器模式 Adapter Pattern
轉接器模式，顧名思義會在兩個同功能但不同的規格的東西中，當作中間溝通的橋樑，就有點像是健康的大頭菜因為放超過一個禮拜，直接變成壞掉的大頭菜，兩個東西都是大頭菜，但規格上可能不太一樣，這時候我們就需要一個大頭菜轉接器，直接把健康的大頭菜給轉到壞掉。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Structural/AdapterPattern/UML.png)

## 實作
首先我們需要先建立健康的大頭菜、以及壞掉的大頭菜，別忘記要建立介面(Interface)來定義大頭菜的規格。

TurnipsInterface.php
```php
/**
 * Interface TurnipsInterface.
 */
interface TurnipsInterface
{
    public function risePrice(int $price): int;

    public function fallPrice(int $price): int;

    public function getPrice(): int;

    public function setPrice(int $price): int;

    public function addCount(int $count): int;

    public function subCount(int $count): int;

    public function getCount(): int;

    public function setCount(int $count): int;

    public function calculatePrice(): int;
}
```

Turnips.php
```php
/**
 * Class Turnips.
 */
class Turnips implements TurnipsInterface
{
    /**
     * @var int
     */
    protected $price;

    /**
     * @var int
     */
    protected $count;

    /**
     * Turnips constructor.
     *
     * @param int $price
     * @param int $count
     */
    public function __construct(int $price, int $count)
    {
        $this->price = $price;
        $this->count = $count;
    }

    /**
     * @param int $pirce
     * 
     * @return int
     */
    public function risePrice(int $price): int
    {
        $this->price += $price;

        return $this->price;
    }

    /**
     * @param int $price
     * 
     * @return int
     */
    public function fallPrice(int $price): int
    {
        $this->price -= $price;

        return $this->price;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     * 
     * @return int
     */
    public function setPrice(int $price): int
    {
        $this->price = $price;

        return $this->price;
    }

    /**
     * @param int $count
     * 
     * @return int
     */
    public function addCount(int $count): int
    {
        $this->count += $count;

        return $this->count;
    }

    /**
     * @param int $count
     * 
     * @return int
     */
    public function subCount(int $count): int
    {
        $this->count -= $count;

        return $this->count;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     * 
     * @return int
     */
    public function setCount(int $count): int
    {
        $this->count = $count;

        return $this->count;
    }

    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        if (isset($this->price) && isset($this->count)) {
            return $this->price * $this->count;
        } else {
            return 0;
        }
    }
}
```

SpoiledInterface.php
```php
/**
 * Interface SpoiledInterface.
 */
interface SpoiledInterface
{
    public function risePrice(int $price): int;

    public function fallPrice(int $price): int;

    public function addCount(int $count): int;

    public function subCount(int $count): int;
    
    public function calculatePrice(): int;
}
```

Spoiled.php
```php
/**
 * Class Spoiled.
 */
class Spoiled implements SpoiledInterface
{
    /**
     * @var int
     */
    protected $price;

    /**
     * @var int
     */
    protected $count;

    /**
     * Spoiled constructor.
     *
     * @param int $price
     * @param int $count
     */
    public function __construct(int $price, int $count)
    {
        $this->price = $price;
        $this->count = $count;
    }

    /**
     * @param int $pirce
     * 
     * @return int
     */
    public function risePrice(int $price): int
    {
        $this->price += $price;

        return $this->price;
    }

    /**
     * @param int $price
     * 
     * @return int
     */
    public function fallPrice(int $price): int
    {
        $this->price -= $price;

        return $this->price;
    }

    /**
     * @param int $count
     * 
     * @return int
     */
    public function addCount(int $count): int
    {
        $this->count += $count;

        return $this->count;
    }

    /**
     * @param int $count
     * 
     * @return int
     */
    public function subCount(int $count): int
    {
        $this->count -= $count;

        return $this->count;
    }

    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        if (isset($this->price) && isset($this->count)) {
            return 0 * $this->count;
        } else {
            return 0;
        }
    }
}
```

再來我們需要為健康的大頭菜以及壞掉的大頭菜製作轉接器，概念上是引用壞掉的大頭菜介面，把健康的大頭菜丟進去，讓大頭菜以壞掉的方式來運作。

TurnipsAdapter.php
```php
/**
 * Class TurnipsAdapter.
 */
class TurnipsAdapter implements SpoiledInterface
{
    /**
     * @var TurnipsInterface
     */
    protected $turnips;

    /**
     * @param TurnipsInterface $turnips
     */
    public function __construct(TurnipsInterface $turnips)
    {
        $this->turnips = $turnips;
    }

    /**
     * @param int $pirce
     * 
     * @return int
     */
    public function risePrice(int $price): int
    {
        $this->turnips->setPrice(0);

        return $this->turnips->getPrice();
    }

    /**
     * @param int $price
     * 
     * @return int
     */
    public function fallPrice(int $price): int
    {
        $this->turnips->setPrice(0);

        return $this->turnips->getPrice();
    }

    /**
     * @param int $count
     * 
     * @return int
     */
    public function addCount(int $count): int
    {
        $this->turnips->addCount($count);

        return $this->count;
    }

    /**
     * @param int $count
     * 
     * @return int
     */
    public function subCount(int $count): int
    {
        $this->turnips->subCount($count);

        return $this->turnips->getCount();
    }

    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        if (isset($this->price) && isset($this->count)) {
            return 0 * $this->count;
        } else {
            return 0;
        }
    }
}
```

## 測試
寫完大頭菜轉接器以後，我們要來測試轉接器是否能夠正常使用，這裡會有幾個測試的重要項目：
1. 測試大頭菜是否能夠正常賦予數量及價格，並且漲價 10 鈴錢、減少 20 組，最後算出價格是否符合。
2. 測試大頭菜是否能夠正常賦予數量及價格，並且透過大頭菜轉接器把它轉成壞掉的大頭菜，最後漲價 10 鈴錢、減少 20 組，最後算出價格是否根本沒辦法賣鈴錢。

AdapterPatternTest.php
```php
/**
 * Class AdapterPatternTest.
 */
class AdapterPatternTest extends TestCase
{
    /**
     * 測試大頭菜是否能夠正常賦予數量及價格，並且漲價 10 鈴錢、減少 20 組，最後算出價格是否符合。
     * 
     * @test
     */
    public function test_can_rise_price_and_sub_count_on_turnips()
    {
        $turnips = new Turnips(100, 40);
        $turnips->risePrice(10);
        $turnips->subCount(20);

        $this->assertEquals(2200, $turnips->calculatePrice());
    }

    /**
     * 測試大頭菜是否能夠正常賦予數量及價格，並且透過大頭菜轉接器把它轉成壞掉的大頭菜
     * 最後漲價 10 鈴錢、減少 20 組，最後算出價格是否根本沒辦法賣鈴錢。
     * 
     * @test
     */
    public function test_can_rise_price_and_sub_count_on_spoiled()
    {
        $turnips = new Turnips(100, 40);
        $turnipsAdapter = new TurnipsAdapter($turnips);
        $turnipsAdapter->risePrice(10);
        $turnipsAdapter->subCount(20);

        $this->assertEquals(0, $turnipsAdapter->calculatePrice());
    }
}
```

最後測試的執行結果會獲得如下：

```
PHPUnit Pretty Result Printer 0.28.0 by Codedungeon and contributors.
==> Configuration: ~/php-design-pattern/vendor/codedungeon/phpunit-result-printer/src/phpunit-printer.yml

PHPUnit 9.2.6 by Sebastian Bergmann and contributors.


 ==> AbstractFactoryTest        ✔  ✔  ✔  ✔  
 ==> BuilderPatternTest         ✔  ✔  
 ==> FactoryMethodTest          ✔  ✔  ✔  ✔  
 ==> PoolPatternTest            ✔  ✔  
 ==> PrototypePatternTest       ✔  ✔  
 ==> SimpleFactoryTest          ✔  ✔  ✔  ✔  
 ==> SingletonPatternTest       ✔  
 ==> StaticFactoryTest          ✔  ✔  ✔  ✔  ✔  
 ==> AdapterPatternTest         ✔  ✔  

Time: 00:00.050, Memory: 6.00 MB

OK (28 tests, 72 assertions)
```

## 完整程式碼
[設計模式不難，找回快樂而已，以大頭菜為例。](https://github.com/Kantai235/php-design-pattern)
- [技術部落格文章 - 轉接器模式](https://kantai235.github.io/AdapterPattern)
- [轉接器模式 原始碼](https://github.com/Kantai235/php-design-pattern/tree/master/DesignPatterns/Structural/AdapterPattern)
- [轉接器模式 測試](https://github.com/Kantai235/php-design-pattern/tree/master/Tests/Structural/AdapterPatternTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

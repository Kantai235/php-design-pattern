![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Structural/BridgePattern/Banner.png)

# 橋接模式 Bridge Pattern
橋接模式，將實作體系與抽象體系分離開來，讓兩者能各自更動各自演進，就有點像是大頭菜有分健康的大頭菜及壞掉的大頭菜，你的島上有這兩種大頭菜，但是健康的大頭菜過了一個禮拜都沒賣掉的話，他就會變成壞掉的大頭菜了。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Structural/BridgePattern/UML.png)

## 實作
首先我們要來把大頭菜做出來，因此會有定義大頭菜介面 Interface、建立健康的大頭菜及壞掉的大頭菜。

TurnipsInterface.php
```php
/**
 * Interface TurnipsInterface.
 */
interface TurnipsInterface
{
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

Spoiled.php
```php
/**
 * Class Spoiled.
 */
class Spoiled implements TurnipsInterface
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

接下來我們要建立所謂的橋樑，這裡有個重要的地方是實作(Implementation)，功能是來去替換大頭菜的類別。

BaseService.php
```php
/**
 * Class BaseService.
 */
abstract class BaseService
{
    /**
     * @var TurnipsInterface
     */
    protected $implementation;

    /**
     * @param TurnipsInterface $turnips
     */
    public function __construct(TurnipsInterface $turnips)
    {
        $this->implementation = $turnips;
    }

    /**
     * @param TurnipsInterface $turnips
     */
    public function setImplementation(TurnipsInterface $turnips)
    {
        $this->implementation = $turnips;
    }

    abstract public function calculatePrice();
}
```

TurnipsService.php
```php
/**
 * Class TurnipsService.
 */
class TurnipsService extends BaseService
{
    /**
     * @return int
     */
    public function calculatePrice()
    {
        return $this->implementation->calculatePrice();
    }
}
```

## 測試
最後我們要來寫幾些測試項目，主要測試建立 `Service` 並且執行計算，以及是否能夠替換大頭菜類別，並且計算。
1. 測試是否能建立 Service 並把健康的大頭菜塞進去，然後計算鈴錢。
2. 測試是否能建立 Service 並把壞掉的大頭菜塞進去，然後計算鈴錢。
3. 測試是否能建立 Service 並把健康的大頭菜塞進去，然後計算鈴錢，再把大頭菜替換成壞掉的大頭菜，再計算一次鈴錢。

BridgePatternTest.php
```php
/**
 * Class BridgePatternTest.
 */
class BridgePatternTest extends TestCase
{
    /**
     * 測試是否能建立 Service 並把健康的大頭菜塞進去，然後計算鈴錢。
     * 
     * @test
     */
    public function test_can_calculate_price_for_turnips()
    {
        $service = new TurnipsService(new Turnips(100, 40));
        $this->assertEquals(4000, $service->calculatePrice());
    }
    
    /**
     * 測試是否能建立 Service 並把壞掉的大頭菜塞進去，然後計算鈴錢。
     * 
     * @test
     */
    public function test_can_calculate_price_for_spoiled()
    {
        $service = new TurnipsService(new Spoiled(100, 40));
        $this->assertEquals(0, $service->calculatePrice());
    }
    
    /**
     * 測試是否能建立 Service 並把健康的大頭菜塞進去，然後計算鈴錢，
     * 再把大頭菜替換成壞掉的大頭菜，再計算一次鈴錢。
     * 
     * @test
     */
    public function test_can_calculate_price_for_turnips_and_spoiled()
    {
        $service = new TurnipsService(new Turnips(100, 40));
        $this->assertEquals(4000, $service->calculatePrice());

        $service->setImplementation(new Spoiled(100, 40));
        $this->assertEquals(0, $service->calculatePrice());
    }
}
```

最後測試的執行結果會獲得如下：

```
PHPUnit Pretty Result Printer 0.28.0 by Codedungeon and contributors.
==> Configuration: ~/php-design-pattern/vendor/codedungeon/phpunit-result-printer/src/phpunit-printer.yml

PHPUnit 9.2.6 by Sebastian Bergmann and contributors.


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

Time: 00:00.027, Memory: 6.00 MB

OK (31 tests, 76 assertions)
```

## 完整程式碼
[設計模式不難，找回快樂而已，以大頭菜為例。](https://github.com/Kantai235/php-design-pattern)
- [技術部落格文章 - 橋接模式](https://kantai235.github.io/BridgePattern)
- [橋接模式 原始碼](https://github.com/Kantai235/php-design-pattern/tree/master/DesignPatterns/Structural/BridgePattern)
- [橋接模式 測試](https://github.com/Kantai235/php-design-pattern/tree/master/Tests/Structural/BridgePatternTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

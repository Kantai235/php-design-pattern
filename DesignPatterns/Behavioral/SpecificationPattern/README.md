![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/SpecificationPattern/Banner.png)

# 規格模式 Specification Pattern
規格模式，將邏輯條件給抽離出來，獨立成一個模組，而不是在物件內透過邏輯判斷來撰寫複雜的程式碼，簡化物件所需要實踐的邏輯，物件可以套用一個規則，也可以套用多種規則，就像大頭菜本身的價格運算是一種規格，過期後的價格運算又是另一種規格，可以把這個價格運算的邏輯抽離出來獨立成模組。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/SpecificationPattern/UML.png)

## 實作
首當其中我們需要把大頭菜物件給建立出來，具有價格(price)以及數量(count)的記錄、讀取功能，原本會提供計算鈴錢總計(calculatePrice)的功能，但這部分是運算邏輯，所以我們需要把這個功能抽離出來放到規格模組(Specification)當中。

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
    protected int $price = 0;

    /**
     * @var int
     */
    protected int $count = 0;

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

再來定義規格模組(Specification)的介面，這個介面會需要實作大頭菜尚未補足的邏輯，也就是計算鈴錢價格(calculatePrice)的這項功能。

Specification.php
```php
/**
 * Interface Specification.
 */
interface Specification
{
    /**
     * @return int
     */
    public function calculatePrice(): int;
}
```

最後我們有兩種規格模式，分別是正常的大頭菜、壞掉的大頭菜，我們先來實作正常的情況下，大頭菜的總計鈴錢計算規格，這裡提供了可以丟大頭菜集合的方式，無論你有多少顆大頭菜，你通通都丟過來，我會全部加總一起算，就算是一顆也沒問題。

TurnipsSpecification.php
```php
/**
 * Class TurnipsSpecification.
 */
class TurnipsSpecification implements Specification
{
    /**
     * @var Turnips[]
     */
    protected array $turnips;

    /**
     * Turnips constructor.
     * 
     * @param Turnips[] $turnips
     */
    public function __construct(Turnips ...$turnips)
    {
        $this->turnips = $turnips;
    }

    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        $total = 0;
        foreach ($this->turnips as $turnip) {
            $total += $turnip->getPrice() * $turnip->getCount();
        }

        return $total;
    }
}
```

最後是實作壞掉的大頭菜計算模式，這裡也是一樣提供一顆或多顆大頭菜計算，不一樣的點在於因為是壞掉的大頭菜，無法賣出鈴錢，所以無論你丟過來幾顆，我都會回傳給你 0 鈴錢。

```php
/**
 * Class SpoiledSpecification.
 */
class SpoiledSpecification implements Specification
{
    /**
     * @var Specification[]
     */
    protected array $turnips;

    /**
     * SpoiledSpecification constructor.
     * 
     * @param Specification[] $turnips
     */
    public function __construct(Specification ...$turnips)
    {
        $this->turnips = $turnips;
    }

    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        return 0;
    }
}
```

## 測試
最後我們要寫個測試，來測試規格模式是不是正確的，主要分別為單顆大頭菜與多顆大頭菜的狀況下，以及正常、壞掉的兩種規格模式的測試。
1. 單顆大頭菜使用正常規格模組，是否能正常計算出鈴錢價格。
2. 多顆大頭菜使用正常規格模組，是否能正常計算出鈴錢價格。
3. 單顆大頭菜使用正常規格模組，再套用壞掉的規格，是否能正常計算出壞掉的鈴錢價格。
4. 多顆大頭菜使用正常規格模組，再套用壞掉的規格，是否能正常計算出壞掉的鈴錢價格。

SpecificationPatternTest.php
```php
/**
 * Class SpecificationPatternTest.
 */
class SpecificationPatternTest extends TestCase
{
    /**
     * @test
     */
    public function test_single_turnips()
    {
        $turnips = new Turnips(100, 40);
        $specification = new TurnipsSpecification($turnips);

        $this->assertEquals(4000, $specification->calculatePrice());
    }

    /**
     * @test
     */
    public function test_multi_turnips()
    {
        $turnips_A = new Turnips(100, 40);
        $turnips_B = new Turnips(90, 20);
        $turnips_C = new Turnips(110, 20);
        $specification = new TurnipsSpecification($turnips_A, $turnips_B, $turnips_C);

        $this->assertEquals(8000, $specification->calculatePrice());
    }

    /**
     * @test
     */
    public function test_single_spoiled()
    {
        $turnips = new Turnips(100, 40);
        $specification = new TurnipsSpecification($turnips);
        $spoiled = new SpoiledSpecification($specification);

        $this->assertEquals(0, $spoiled->calculatePrice());
    }

    /**
     * @test
     */
    public function test_multi_spoiled()
    {
        $turnips_A = new Turnips(100, 40);
        $turnips_B = new Turnips(90, 20);
        $turnips_C = new Turnips(110, 20);
        $specification = new TurnipsSpecification($turnips_A, $turnips_B, $turnips_C);
        $spoiled = new SpoiledSpecification($specification);

        $this->assertEquals(0, $spoiled->calculatePrice());
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
 ==> ObserverPatternTest        ✔  
 ==> SpecificationPatternTest   ✔  ✔  ✔  ✔  
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

Time: 00:00.036, Memory: 8.00 MB

OK (72 tests, 141 assertions)
```

## 完整程式碼
[設計模式不難，找回快樂而已，以大頭菜為例。](https://github.com/Kantai235/php-design-pattern)
- [技術部落格文章 - 規格模式](https://kantai235.github.io/SpecificationPattern)
- [規格模式 原始碼](https://github.com/Kantai235/php-design-pattern/tree/master/DesignPatterns/Behavioral/SpecificationPattern)
- [規格模式 測試](https://github.com/Kantai235/php-design-pattern/tree/master/Tests/Behavioral/SpecificationPatternTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/StrategyPattern/Banner.png)

# 策略模式 Strategy Pattern
策略模式，可以讓物件在運作時更改其行為或算法，你可以透過切換策略物件來改變計有的功能，你需要實作一個介面來代表這個策略物件，然後在主要類別當中去引入這個策略物件，在需要變更時來切換策略物件，來達成不同狀況下所需要的功能，就像是大頭菜的鈴錢有兩種模式，一種是原本的鈴錢，另一種則是過期後歸零，這個鈴錢運算的模式就可以抽離出來作為策略物件。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/StrategyPattern/UML.png)

## 實作
首先我們要定義策略的介面，這個介面我們會希望策略物件必須要實作鈴錢運算(calculatePrice)的方法。

Strategy.php
```php
/**
 * Interface Strategy.
 */
interface Strategy
{
    /**
     * @return int
     */
    public function calculatePrice(int $price, int $count): int;
}
```

再來要實踐大頭菜的策略模式，首先是正常狀況下的大頭菜，會直接拿鈴錢價格、總數相成後即是鈴錢總價，並且將其回傳。

TurnipsStrategy.php
```php
/**
 * Class TurnipsStrategy.
 */
class TurnipsStrategy implements Strategy
{
    /**
     * @return int
     */
    public function calculatePrice(int $price, int $count): int
    {
        return $price * $count;
    }
}
```

至於壞掉的部分，只要大頭菜壞掉就是賣不出去，所以不用進行任何運算，直接回傳 0 鈴錢即可。

SpoliedStrategy.php
```php
/**
 * Class SpoliedStrategy.
 */
class SpoliedStrategy implements Strategy
{
    /**
     * @return int
     */
    public function calculatePrice(int $price, int $count): int
    {
        return 0;
    }
}
```

最後實作大頭菜物件，我們需要順便把策略物件丟進去，如果在建立大頭菜物件時沒有指定策略物件，那麼預設就給予正常的策略物件，並且提供一個可以臨時切換策略物件的方法，以及計算鈴錢總價的方法，這個計算的方法是透過呼叫策略物件的方法來實踐。

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
     * @var Strategy
     */
    protected Strategy $strategy;

    /**
     * Turnips constructor.
     * 
     * @param int $price
     * @param int $count
     * @param Strategy $strategy
     */
    public function __construct(int $price, int $count, Strategy $strategy = null)
    {
        $this->price = $price;
        $this->count = $count;

        // 如果在建立大頭菜物件時沒有指定策略物件，那麼預設就給予正常的策略物件。
        $this->strategy = empty($strategy) ? new TurnipsStrategy() : $strategy;
    }

    /**
     * @param Strategy $strategy
     */
    public function setStrategy(Strategy $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        return $this->strategy->calculatePrice($this->price, $this->count);
    }
}
```

## 測試
最後我們要測試策略大頭菜是否如預期的可以運行，我們接下來有一項測試分別是建立大頭菜物件，並且給予預設正常的策略物件，正常情況下可以計算出鈴錢，這時候把策略物件替換為壞掉的模式，再重複呼叫方法時，則是獲得 0 鈴錢。

StrategyPatternTest.php
```php
/**
 * Class StrategyPatternTest.
 */
class StrategyPatternTest extends TestCase
{
    /**
     * @test
     */
    public function test_strategy()
    {
        $turnips = new Turnips(100, 40, new TurnipsStrategy);
        $this->assertEquals(4000, $turnips->calculatePrice());

        $turnips->setStrategy(new SpoliedStrategy());
        $this->assertEquals(0, $turnips->calculatePrice());
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
 ==> StatePatternTest           ✔  
 ==> StrategyPatternTest        ✔  
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

Time: 00:00.084, Memory: 8.00 MB

OK (74 tests, 147 assertions)
```

## 完整程式碼
[設計模式不難，找回快樂而已，以大頭菜為例。](https://github.com/Kantai235/php-design-pattern)
- [技術部落格文章 - 策略模式](https://kantai235.github.io/StrategyPattern)
- [策略模式 原始碼](https://github.com/Kantai235/php-design-pattern/tree/master/DesignPatterns/Behavioral/StrategyPattern)
- [策略模式 測試](https://github.com/Kantai235/php-design-pattern/tree/master/Tests/Behavioral/StrategyPatternTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

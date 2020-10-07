![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/StatePattern/Banner.png)

# 狀態模式 State Pattern
狀態模式，讓物件的狀態改變時，一同改變物件的行為模式，就像是大頭菜(Turnips)這個物件，有沒有壞掉只是一個狀態(State)來辨別，但如果壞掉了，那麼會因為狀態改變的關係，而讓大頭菜計算鈴錢價格的方式也跟著改變。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/StatePattern/UML.png)

## 實作
因為要讓大頭菜(Turnips)掛載狀態物件，所以我們要先來定義狀態，會需要提供進入到下個狀態的方法，以及 `toString` 來查看當前的狀態是什麼。

State.php
```php
/**
 * Interface State.
 */
interface State
{
    /**
     * @param Turnips $turnips
     */
    public function proceedToNext(Turnips $turnips);

    /**
     * @return string
     */
    public function toString(): string;
}
```

首先是大頭菜剛建立出來的狀態，而大頭菜下個狀態是壞掉的狀態，所以在 `proceedToNext` 方法我們要將大頭菜(Turnips)來去賦予下個階段的狀態。

StateCreated.php
```php
/**
 * Class StateCreated.
 */
class StateCreated implements State
{
    /**
     * @param Turnips $turnips
     */
    public function proceedToNext(Turnips $turnips)
    {
        $turnips->setState(new StateSpoiled());
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return 'created';
    }
}
```

再來是壞掉的大頭菜狀態，這個階段已經是最終階段了，所以在 `proceedToNext` 的部分則是不實作任何事。

StateSpoiled.php
```php
/**
 * Class StateSpoiled.
 */
class StateSpoiled implements State
{
    /**
     * @param Turnips $turnips
     */
    public function proceedToNext(Turnips $turnips)
    {
        // there is nothing more to do
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return 'spoiled';
    }
}
```

最後我們要實作大頭菜(Turnips)，除了要儲存鈴錢價格(Price)、數量(Count)以外，還要儲存當前的狀態(State)，這個狀態會在一開始被建立時就擁有，並且會在執行 `proceedToNext` 時被變更，最後提供計算鈴錢總價格的 `calculatePrice` 方法，並且根據當前的狀態(State)來切換計算模式。

Turnips.php
```php
/**
 * Class Turnips.
 */
class Turnips
{
    /**
     * @var State
     */
    protected State $state;

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
        $this->price = $price;
        $this->count = $count;
    }

    /**
     * @return Turnips
     */
    public static function create(int $price, int $count): Turnips
    {
        $turnips = new self($price, $count);
        $turnips->state = new StateCreated();

        return $turnips;
    }

    /**
     * @param State $state
     */
    public function setState(State $state)
    {
        $this->state = $state;
    }

    /**
     * @return void
     */
    public function proceedToNext()
    {
        $this->state->proceedToNext($this);
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->state->toString();
    }

    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        switch ($this->toString()) {
            case 'created':
                return $this->price * $this->count;

            case 'spoiled':
                return 0;
        }
    }
}
```

## 測試
最後我們要對狀態模式做測試，測試的項目很簡單，就是建立一個大頭菜物件，這時候是健康的大頭菜，所以應該要可以得知大頭菜現在的狀態是剛建立的 `created` 以及正常計算鈴錢價格，再來把大頭菜切換為下個狀態，也就是壞掉的大頭菜，這時候應該要獲得壞掉的狀態 `spoiled` 以及計算出 0 鈴錢。

StatePatternTest.php
```php
/**
 * Class StatePatternTest.
 */
class StatePatternTest extends TestCase
{
    /**
     * @test
     */
    public function test_state_spoiled()
    {
        $turnips = Turnips::create(100, 40);

        $this->assertSame('created', $turnips->toString());
        $this->assertEquals(4000, $turnips->calculatePrice());

        $turnips->proceedToNext();

        $this->assertSame('spoiled', $turnips->toString());
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

Time: 00:00.100, Memory: 8.00 MB

OK (73 tests, 145 assertions)
```

## 完整程式碼
[設計模式不難，找回快樂而已，以大頭菜為例。](https://github.com/Kantai235/php-design-pattern)
- [技術部落格文章 - 狀態模式](https://kantai235.github.io/StatePattern)
- [狀態模式 原始碼](https://github.com/Kantai235/php-design-pattern/tree/master/DesignPatterns/Behavioral/StatePattern)
- [狀態模式 測試](https://github.com/Kantai235/php-design-pattern/tree/master/Tests/Behavioral/StatePatternTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

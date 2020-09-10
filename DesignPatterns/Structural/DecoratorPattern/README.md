![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Structural/DecoratorPattern/Banner.png)

# 修飾模式 Decorator Pattern
修飾模式，或者稱裝飾者模式，為物件動態增加新的方法，就想像你最初的大頭菜沒有想過他會壞掉，某天突然覺得讓大頭菜壞掉好像很好玩，但你不能把整個大頭菜砍掉重練，所以你希望可以不改變既有的大頭菜，在大頭菜額外再套上新的功能，那就是壞掉。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Structural/DecoratorPattern/UML.png)

## 實作
首先我們會需要定義出最初始大頭菜的介面，以及其最初的功能。

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

TurnipsService.php
```php
/**
 * Class TurnipsService.
 */
class TurnipsService implements TurnipsInterface
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
     * TurnipsService constructor.
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
        return $this->price * $this->count;
    }
}
```

再來我們需要建立裝飾器(Decorator)，來修飾我們後來添加的壞掉功能，並且把最初始的大頭菜丟進去，讓大頭菜直接壞掉，沒有壞掉就拿石頭丟他！

TurnipsDecorator.php
```php
/**
 * Class TurnipsDecorator.
 */
abstract class TurnipsDecorator implements TurnipsInterface
{
    /**
     * @var TurnipsInterface
     */
    protected $turnips;

    /**
     * TurnipsDecorator constructor.
     * 
     * @param TurnipsInterface $turnips
     */
    public function __construct(TurnipsInterface $turnips)
    {
        $this->turnips = $turnips;
    }
}
```

Turnips.php
```php
/**
 * Class Turnips.
*/
class Turnips extends TurnipsDecorator
{
    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        return $this->turnips->calculatePrice();
    }
}
```

Spoiled.php
```php
/**
 * Class Spoiled.
*/
class Spoiled extends TurnipsDecorator
{
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
完成了大頭菜裝飾器之後，我們接下來要驗證前面所寫的裝飾器是否能夠正常運行，因此我們有幾個重要項目要來做測試：
1. 測試正常的大頭菜是否可以賣鈴錢。
2. 測試壞掉的大頭菜是否沒辦法賣鈴錢。

```php
/**
 * Class DecoratorPatternTest.
 */
class DecoratorPatternTest extends TestCase
{
    /**
     * 測試正常的大頭菜是否可以賣鈴錢。
     * 
     * @test
     */
    public function test_turnips()
    {
        $service = new TurnipsService(100, 40);
        $turnips = new Turnips($service);

        $this->assertEquals(4000, $turnips->calculatePrice());
    }

    /**
     * 測試壞掉的大頭菜是否沒辦法賣鈴錢。
     * 
     * @test
     */
    public function test_spoiled()
    {
        $service = new TurnipsService(100, 40);
        $turnips = new Spoiled($service);

        $this->assertEquals(0, $turnips->calculatePrice());
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
 ==> CompositePatternTest       ✔  ✔  ✔  
 ==> DataMapperTest             ✔  ✔  
 ==> DecoratorPatternTest       ✔  ✔  

Time: 00:00.050, Memory: 6.00 MB

OK (41 tests, 88 assertions)
```

## 完整程式碼
[設計模式不難，找回快樂而已，以大頭菜為例。](https://github.com/Kantai235/php-design-pattern)
- [技術部落格文章 - 修飾模式](https://kantai235.github.io/DecoratorPattern)
- [修飾模式 原始碼](https://github.com/Kantai235/php-design-pattern/master/DesignPatterns/Structural/DecoratorPattern)
- [修飾模式 測試](https://github.com/Kantai235/php-design-pattern/master/Tests/Structural/DecoratorPatternTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

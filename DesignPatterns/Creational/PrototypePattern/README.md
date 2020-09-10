![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Creational/PrototypePattern/Banner.png)

# 原型模式 Prototype Pattern
原型模式，你有些物件可能會需要建立很多一樣的物件，只是某些資料不太一樣而已，就有點像是每顆大頭菜都是一模一樣的物件，但可能因為來自不同的島，所以每顆大頭菜的差別只在於那起始購買的鈴錢不同。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Creational/PrototypePattern/UML.png)

## 實作
首先我們需要以抽象類別的方式，來製作大頭菜的原型，並且定義好大頭菜的基本功能。

TurnipsPrototype.php
```php
/**
 * Class TurnipsPrototype.
 */
abstract class TurnipsPrototype
{
    /**
     * @var string
     */
    protected $category;

    /**
     * @var int
     */
    protected $price;

    /**
     * @var int
     */
    protected $count;

    abstract public function __clone();

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

再來建立健康的大頭菜、壞掉的大頭菜，並且引用大頭菜原型，這裡需要注意我們須要去實作 `__clone` 方法，這樣子才能讓大頭菜複製、貼上。

Turnips.php
```php
/**
 * Class Turnips.
 */
class Turnips extends TurnipsPrototype
{
    /**
     * @var string
     */
    protected $category = '大頭菜';

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
     * ...
     */
    public function __clone()
    {
        // TODO: Implement __Clone() method.
    }
}
```

SpoiledTurnips.php
```php
/**
 * Class SpoiledTurnips.
 */
class SpoiledTurnips extends TurnipsPrototype
{
    /**
     * @var string
     */
    protected $category = '壞掉的大頭菜';

    /**
     * 壞掉的大頭菜是沒辦法賣鈴錢的狸！
     * 
     * @var int
     */
    const SPOILED_PRICE = 0;

    /**
     * SpoiledTurnips constructor.
     *
     * @param int $price
     * @param int $count
     */
    public function __construct(int $price, int $count)
    {
        $this->price = self::SPOILED_PRICE;
        $this->count = $count;
    }

    /**
     * ...
     */
    public function __clone()
    {
        // TODO: Implement __Clone() method.
    }
}
```

## 測試
最後要來驗證一下我們所寫的原型是否是正確的，所以這次的測試也比較簡單，原型模式著重於大頭菜可以被複製，每個被複製出來的大頭菜只有局部的內容不一樣，以最節省資源的方式，來處理重複性質高的物件。
1. 建立大頭菜，並且複製 10 次，檢查每次大頭菜是否都是大頭菜，而且價格是正確的。
2. 建立壞掉的大頭菜，並且複製 10 次，檢查每次大頭菜是否都是壞掉的大頭菜，而且都賣不了錢。

```php
/**
 * Class PrototypePatternTest.
 */
class PrototypePatternTest extends TestCase
{
    /**
     * 建立大頭菜，並且複製 10 次，
     * 檢查每次大頭菜是否都是大頭菜，而且價格是正確的。
     * 
     * @test
     */
    public function test_can_clone_turnips()
    {
        $turnips = new Turnips(100, 40);

        for ($i = 0; $i < 10; $i++) {
            $_turnips = clone $turnips;

            $this->assertInstanceOf(Turnips::class, $_turnips);
            $this->assertEquals(4000, $_turnips->calculatePrice());
        }
    }

    /**
     * 建立壞掉的大頭菜，並且複製 10 次，
     * 檢查每次大頭菜是否都是壞掉的大頭菜，而且都賣不了錢。
     * 
     * @test
     */
    public function test_can_clone_spoiled_turnips()
    {
        $turnips = new SpoiledTurnips(100, 40);

        for ($i = 0; $i < 10; $i++) {
            $_turnips = clone $turnips;
            $this->assertInstanceOf(SpoiledTurnips::class, $_turnips);
            $this->assertEquals(0, $_turnips->calculatePrice());
        }
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

Time: 00:00.050, Memory: 6.00 MB

OK (24 tests, 68 assertions)
```

## 完整程式碼
[設計模式不難，找回快樂而已，以大頭菜為例。](https://github.com/Kantai235/php-design-pattern)
- [技術部落格文章 - 原型模式](https://kantai235.github.io/PrototypePattern)
- [原型模式 原始碼](https://github.com/Kantai235/php-design-pattern/master/DesignPatterns/Creational/PrototypePattern)
- [原型模式 測試](https://github.com/Kantai235/php-design-pattern/master/Tests/Creational/PrototypePatternTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

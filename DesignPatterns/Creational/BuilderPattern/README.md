![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Creational/BuilderPattern/Banner.png)

# 建造者模式 Builder Pattern
建造者模式，主要用來建立複雜的物件，就有點像是大頭菜的功能組成，從鈴錢價格、組合數量、現場實價 ... 等等，為了簡化把每個功能都去不斷地建立物件、塞入物件的動作，因此可以指派一個建造者，並且賦予建造模式，然後透過指定的方法來建造物件，你不需要歷經繁瑣的過程，就能獲得擁有複雜功能的物件。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Creational/BuilderPattern/UML.png)

## 實作
在寫建造者之前，我們需要先把很複雜的大頭菜給做出來，為了把大頭菜變複雜，所以把價格(Price)以及數量(Count)抽離出來做成物件。

Price.php
```php
/**
 * Class Price.
 */
class Price
{
    /**
     * @var int
     */
    protected int $price = 0;

    /**
     * Price constructor.
     * 
     * @param int $price
     */
    public function __construct(int $price)
    {
        $this->set($price);
    }

    /**
     * @return int
     */
    public function get(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function set(int $price)
    {
        $this->price = $price;
    }
}
```

Count.php
```php
/**
 * Class Count.
 */
class Count
{
    /**
     * @var int
     */
    protected int $price = 0;

    /**
     * Price constructor.
     * 
     * @param int $price
     */
    public function __construct(int $count)
    {
        $this->set($count);
    }

    /**
     * @return int
     */
    public function get(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function set(int $count)
    {
        $this->count = $count;
    }
}
```

再來要建立大頭菜，大頭菜會有個原型(Prototype)，然後建立健康的大頭菜、壞掉的大頭菜，並且引用大頭菜原型。

TurnipsPrototype.php
```php
/**
 * Class TurnipsPrototype.
 */
abstract class TurnipsPrototype
{
    /**
     * @var Price
     */
    protected Price $price;

    /**
     * @var Count
     */
    protected Count $count;

    abstract public function calculatePrice(): int;

    /**
     * @param int $price
     */
    public function setPrice(int $price)
    {
        $this->price = new Price($price);
    }

    /**
     * @param int $count
     */
    public function setCount(int $count)
    {
        $this->count = new Count($count);
    }
}
```

Turnips.php
```php
/**
 * Class Turnips.
 */
class Turnips extends TurnipsPrototype
{
    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        if (isset($this->price) && isset($this->count)) {
            return $this->price->get() * $this->count->get();
        } else {
            return 0;
        }
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
     * @return int
     */
    public function calculatePrice(): int
    {
        if (isset($this->price) && isset($this->count)) {
            return 0 * $this->count->get();
        } else {
            return 0;
        }
    }
}
```

我們已經把好像很複雜，但沒那麼複雜的大頭菜給定義出來了，接下來我們要建立建造者，建造者的工作就是負責把沒那麼複雜的大頭菜給建立出來，所以我們要先定義建造者的介面 Interface，並且建立健康的大頭菜建造者、壞掉的大頭菜建造者，並且去實作建造者的功能。

BuilderContract.php
```php
/**
 * Interface BuilderContract.
 */
interface BuilderContract
{
    public function createTurnips();

    public function setPrice(int $price);

    public function setCount(int $count);

    public function getTurnips(): TurnipsPrototype;
}
```

TurnipsBuilder.php
```php
/**
 * Class TurnipsBuilder.
 */
class TurnipsBuilder implements BuilderContract
{
    /**
     * @var Turnips
     */
    protected Turnips $turnips;

    /**
     * 
     */
    public function createTurnips()
    {
        $this->turnips = new Turnips();
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price)
    {
        $this->turnips->setPrice($price);
    }

    /**
     * @param int $count
     */
    public function setCount(int $count)
    {
        $this->turnips->setCount($count);
    }

    /**
     * @return Turnips
     */
    public function getTurnips(): Turnips
    {
        return $this->turnips;
    }
}
```

SpoiledTurnipsBuilder.php
```php
/**
 * Class SpoiledTurnipsBuilder.
 */
class SpoiledTurnipsBuilder implements BuilderContract
{
    /**
     * 壞掉的大頭菜是沒辦法賣鈴錢的狸！
     * 
     * @var int
     */
    const SPOILED_PRICE = 0;

    /**
     * @var SpoiledTurnips
     */
    protected SpoiledTurnips $turnips;

    /**
     * 
     */
    public function createTurnips()
    {
        $this->turnips = new SpoiledTurnips();
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price)
    {
        $this->turnips->setPrice($price);
    }

    /**
     * @param int $count
     */
    public function setCount(int $count)
    {
        $this->turnips->setCount(self::SPOILED_PRICE);
    }

    /**
     * @return SpoiledTurnips
     */
    public function getTurnips(): SpoiledTurnips
    {
        return $this->turnips;
    }
}
```

最後我們要製作 `Director` 來負責控制建造者，只要把大頭菜建造者丟進去，大頭菜建造者就會開始製作大頭菜，並且把大頭菜丟出來給我們，而製造大頭菜這之間的過程，我們都不需要操心。

Director.php
```php
/**
 * Class Director.
 */
class Director
{
    /**
     * @param BuilderContract $builder
     * @param int $price
     * @param int $count
     * 
     * @return TurnipsPrototype
     */
    public function build(BuilderContract $builder, int $price, int $count): TurnipsPrototype
    {
        $builder->createTurnips();
        $builder->setPrice($price);
        $builder->setCount($count);

        return $builder->getTurnips();
    }
}
```

## 測試
最後我們要對我們的大頭菜建造者做幾些測試，主要的測試項目如下：
1. 測試是否能夠正常建立大頭菜。
2. 測試是否能夠正常建立壞掉的大頭菜。
3. 測試大頭菜是否能夠正常計算價格。
4. 測試壞掉的大頭菜是否能夠正常計算價格。

BuilderPatternTest.php
```php
/**
 * Class BuilderPatternTest.
 */
class BuilderPatternTest extends TestCase
{
    /**
     * 測試是否能夠正常建立大頭菜。
     * 
     * @test
     */
    public function test_can_build_turnips()
    {
        $builder = new TurnipsBuilder();
        $turnips = (new Director())->build($builder, 100, 40);

        $this->assertInstanceOf(Turnips::class, $turnips);
    }

    /**
     * 測試是否能夠正常建立壞掉的大頭菜。
     * 
     * @test
     */
    public function test_can_build_spoiled_turnips()
    {
        $builder = new SpoiledTurnipsBuilder();
        $turnips = (new Director())->build($builder, 100, 40);

        $this->assertInstanceOf(SpoiledTurnips::class, $turnips);
    }

    /**
     * 測試大頭菜是否能夠正常計算價格。
     * 
     * @test
     */
    public function test_can_calculate_price_for_turnips()
    {
        $builder = new TurnipsBuilder();
        $turnips = (new Director())->build($builder, 100, 40);

        $this->assertEquals(4000, $turnips->calculatePrice());
    }

    /**
     * 測試壞掉的大頭菜是否能夠正常計算價格。
     * 
     * @test
     */
    public function test_can_calculate_price_for_spoiled_turnips()
    {
        $builder = new SpoiledTurnipsBuilder();
        $turnips = (new Director())->build($builder, 100, 40);

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

Time: 00:00.050, Memory: 6.00 MB

OK (26 tests, 70 assertions)
```

## 完整程式碼
[設計模式不難，找回快樂而已，以大頭菜為例。](https://github.com/Kantai235/php-design-pattern)
- [技術部落格文章 - 建造者模式](https://kantai235.github.io/BuilderPattern)
- [建造者模式 原始碼](https://github.com/Kantai235/php-design-pattern/master/DesignPatterns/Creational/BuilderPattern)
- [建造者模式 測試](https://github.com/Kantai235/php-design-pattern/master/Tests/Creational/BuilderPatternTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

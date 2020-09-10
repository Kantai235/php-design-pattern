![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Creational/FactoryMethod/Banner.png)

# 工廠方法 Factory Method
工廠方法，跟抽象工廠有點像，可是又沒那麼像，抽象工廠的工廠會有個抽象類別，並且把工廠要做且會重工的事情寫在抽象類別當中，而工廠方法則是需要定義一個工廠介面，並且讓工廠去實作，如果看到工廠介面不小心定義成抽象工廠，就拿網子打他，有點像是曹賣的奶奶會賣大頭菜，曹賣也會賣大頭菜，所以他們都有一個介面定義他們會賣大頭菜。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Creational/FactoryMethod/UML.png)

## 實作

首先我們一樣要先建立大頭菜介面，並且定義大頭菜需要有哪些功能，再來建立健康的大頭菜、壞掉的大頭菜，先有大頭菜才有大頭菜工廠。

TurnipsContract.php
```php
/**
 * Interface TurnipsContract.
 */
interface TurnipsContract
{
    public function calculatePrice(): int;
}
```

然後我們要新增新鮮的大頭菜、壞掉的大頭菜，並且去實作大頭菜介面所定義的條件。

Turnips.php
```php
/**
 * Class Turnips.
 */
class Turnips implements TurnipsContract
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

SpoiledTurnips.php
```php
/**
 * Class SpoiledTurnips.
 */
class SpoiledTurnips implements TurnipsContract
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
     * SpoiledTurnips constructor.
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
        if (isset($this->count)) {
            return 0 * $this->count;
        } else {
            return 0;
        }
    }
}
```

接下來我們要建立個別的大頭菜工廠，分別是健康的大頭菜工廠、壞掉的大頭菜工廠，但在此之前，我們要先定義什麼是工廠。

FactoryContract.php
```php
/**
 * Interface TurnipsFactoryContract.
 */
interface TurnipsFactoryContract
{
    public function createTurnips(int $price, int $count): TurnipsContract;
}
```

定義完工廠以後，我們最後要來建立健康的大頭菜工廠、壞掉的大頭菜工廠。

TurnipsFactory.php
```php
/**
 * Class TurnipsFactory.
 */
class TurnipsFactory implements FactoryContract
{
    /**
     * @param int $price
     * @param int $count
     * 
     * @return TurnipsContract
     */
    public function createTurnips(int $price, int $count): TurnipsContract
    {
        return new Turnips($price, $count);
    }
}
```

SpoiledTurnipsFactory.php
```php
/**
 * Class SpoiledTurnipsFactory.
 */
class SpoiledTurnipsFactory implements FactoryContract
{
    /**
     * @var int
     */
    const SPOILED_PRICE = 0;

    /**
     * @param int $price
     * @param int $count
     * 
     * @return TurnipsContract
     */
    public function createTurnips(int $price, int $count): TurnipsContract
    {
        return new SpoiledTurnips(self::SPOILED_PRICE, $count);
    }
}
```

## 測試
最後我們要來測試我們寫的大頭菜工廠方法是否可以正常運作，因此會有幾個需要測試的重點項目：
1. 測試是否能夠建立健康的大頭菜。
2. 測試是否能夠建立壞掉的大頭菜。
3. 測試健康的大頭菜是否能夠正常計算價格。
4. 測試壞掉的大頭菜是否能夠正常計算價格。

```php
/**
 * Class FactoryMethodTest.
 */
class FactoryMethodTest extends TestCase
{
    /**
     * 測試是否能夠正常建立大頭菜。
     * 
     * @test
     */
    public function test_can_create_turnips()
    {
        $factory = new TurnipsFactory(100, 40);
        $turnips = $factory->createTurnips();

        $this->assertInstanceOf(Turnips::class, $turnips);
    }

    /**
     * 測試是否能夠正常建立壞掉的大頭菜。
     * 
     * @test
     */
    public function test_can_create_spoiled_turnips()
    {
        $factory = new SpoiledTurnipsFactory(40);
        $turnips = $factory->createTurnips();
        
        $this->assertInstanceOf(SpoiledTurnips::class, $turnips);
    }

    /**
     * 測試是否能夠正常計算大頭菜的價格。
     * 
     * @test
     */
    public function test_can_calculate_price_for_turnips()
    {
        $factory = new TurnipsFactory(100, 40);
        $turnips = $factory->createTurnips();

        $this->assertEquals(4000, $turnips->calculatePrice());
    }

    /**
     * 測試是否能夠正常計算壞掉的大頭菜的價格。
     * 
     * @test
     */
    public function test_can_calculate_price_for_spoiled_turnips()
    {
        $factory = new SpoiledTurnipsFactory(40);
        $turnips = $factory->createTurnips();

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
- [技術部落格文章 - 工廠方法](https://kantai235.github.io/FactoryMethod)
- [工廠方法 原始碼](https://github.com/Kantai235/php-design-pattern/master/DesignPatterns/Creational/FactoryMethod)
- [工廠方法 測試](https://github.com/Kantai235/php-design-pattern/master/Tests/Creational/FactoryMethodTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

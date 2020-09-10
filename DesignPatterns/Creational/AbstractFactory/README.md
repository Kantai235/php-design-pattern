![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Creational/AbstractFactory/Banner.png)

# 抽象工廠 Abstract Factory
抽象工廠，跟靜態工廠有點像，只是它沒那麼靜態，你需要先把工廠建立出來，才能開始生產大頭菜，就有點像是星期日的早上時，你打開 Switch 需要先看西施惠晨報，這時候島上正在把曹賣叫過來，你聽完晨報時，曹賣也到島上了。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Creational/AbstractFactory/UML.png)

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
 * Interface FactoryContract.
 */
interface FactoryContract
{
    public function createTurnips(int $price, int $count): TurnipsContract;
}
```

並且實作出一個抽象的大頭菜工廠，這個抽象工廠會把具有重複性質的事情實作出來。

BaseFactory.php
```php
/**
 * Class BaseFactory.
 */
abstract class BaseFactory implements FactoryContract
{
    /**
     * @param string $type
     * @param int    $price
     * @param int    $count
     * 
     * @return TurnipsContract
     */
    public function createTurnips(string $type, int $price, int $count): TurnipsContract
    {
        if ($type === '大頭菜') {
            return new Turnips($price, $count);
        }

        if ($type === '壞掉的大頭菜') {
            return new SpoiledTurnips($price, $count);
        }

        throw new \InvalidArgumentException('找不到這種大頭菜分類。');
    }
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
寫完抽象大頭菜工廠了以後，我們接下來要寫些測試來驗證我們的抽象大頭菜工廠是否正確，因此有幾個測試項目要來驗證：
1. 測試是否能夠建立健康的大頭菜。
2. 測試是否能夠建立壞掉的大頭菜。
3. 測試健康的大頭菜是否能夠正常計算價格。
4. 測試壞掉的大頭菜是否能夠正常計算價格。

AbstractFactoryTest.php
```php
/**
 * Class AbstractFactoryTest.
 */
class AbstractFactoryTest extends TestCase
{
    /**
     * 測試是否能夠建立大頭菜。
     * 
     * @test
     */
    public function test_can_create_turnips()
    {
        $factory = new TurnipsFactory();
        $turnips = $factory->createTurnips(100, 40);

        $this->assertInstanceOf(Turnips::class, $turnips);
    }

    /**
     * 測試是否能夠建立壞掉的大頭菜。
     * 
     * @test
     */
    public function test_can_create_spoiled_turnips()
    {
        $factory = new SpoiledTurnipsFactory();
        $turnips = $factory->createTurnips(100, 40);

        $this->assertInstanceOf(SpoiledTurnips::class, $turnips);
    }

    /**
     * 測試大頭菜是否能夠正常計算價格。
     * 
     * @test
     */
    public function test_can_calculate_price_for_turnips()
    {
        $factory = new TurnipsFactory();
        $turnips = $factory->createTurnips(100, 40);

        $this->assertEquals(4000, $turnips->calculatePrice());
    }

    /**
     * 測試壞掉的大頭菜是否能夠正常計算價格。
     * 
     * @test
     */
    public function test_can_calculate_price_for_spoiled_turnips()
    {
        $factory = new SpoiledTurnipsFactory();
        $turnips = $factory->createTurnips(100, 40);

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
- [技術部落格文章 - 抽象工廠](https://kantai235.github.io/AbstractFactory)
- [抽象工廠 原始碼](https://github.com/Kantai235/php-design-pattern/master/DesignPatterns/Creational/AbstractFactory)
- [抽象工廠 測試](https://github.com/Kantai235/php-design-pattern/master/Tests/Creational/AbstractFactoryTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Creational/StaticFactory/Banner.png)

# 靜態工廠 Static Factory
靜態工廠，顧名思義就是希望這整個工廠都是屬於靜態屬性的，無論到哪裡都以靜態方法來使用這個工廠，就像是在星期日的早上時，會有個曹賣在你的島上走來走去，但無論曹賣走到哪裡，你都可以跟曹賣買大頭菜。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Creational/StaticFactory/UML.png)

## 實作
首先我們這次會有兩種大頭菜，一種是新鮮的大頭菜(Turnips)，另一種是壞掉的大頭菜(Spoiled Trunips)，但因為它們都是大頭菜，所以我們要先寫個大頭菜介面，並解定義大頭菜應該具備哪些條件。

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

最後我們要建立大頭菜的靜態工廠，建立大頭菜的方法以靜態的方式宣告，並且根據參數來回傳不同的大頭菜。

TurnipsFactory.php
```php
use InvalidArgumentException;

/**
 * Class TurnipsFactory.
 */
final class TurnipsFactory
{
    /**
     * @param string $type
     * @param int    $price
     * @param int    $count
     *
     * @throws InvalidArgumentException
     * @return TurnipsContract
     */
    public static function factory(string $type, int $price, int $count): TurnipsContract
    {
        if ($type === '大頭菜') {
            return new Turnips($price, $count);
        }

        if ($type === '壞掉的大頭菜') {
            return new SpoiledTurnips($price, $count);
        }

        throw new InvalidArgumentException('找不到這種大頭菜分類。');
    }
}
```

## 測試

再來為了驗證我們所寫的大頭菜靜態工廠是否正確，所以我們要來寫個測試，主要測試的項目如下：
1. 測試是否能夠正常建立大頭菜。
2. 測試是否能夠正常建立壞掉的大頭菜。
3. 測試是否能夠正常計算大頭菜的價格。
4. 測試是否能夠正常計算壞掉的大頭菜的價格。
5. 測試是否能夠收到未知的大頭菜。

StaticFactoryTest.php
```php
use InvalidArgumentException;

/**
 * Class StaticFactoryTest.
 */
class StaticFactoryTest extends TestCase
{
    /**
     * 測試是否能夠正常建立大頭菜。
     * 
     * @test
     */
    public function test_can_create_turnips()
    {
        $this->assertInstanceOf(Turnips::class, TurnipsFactory::factory('大頭菜', 100, 40));
    }

    /**
     * 測試是否能夠正常建立壞掉的大頭菜。
     * 
     * @test
     */
    public function test_can_create_spoiled_turnips()
    {
        $this->assertInstanceOf(SpoiledTurnips::class, TurnipsFactory::factory('壞掉的大頭菜', 100, 40));
    }

    /**
     * 測試是否能夠正常計算大頭菜的價格。
     * 
     * @test
     */
    public function test_can_calculate_price_for_turnips()
    {
        $turnips = TurnipsFactory::factory('大頭菜', 100, 40);

        $this->assertEquals(4000, $turnips->calculatePrice());
    }

    /**
     * 測試是否能夠正常計算壞掉的大頭菜的價格。
     * 
     * @test
     */
    public function test_can_calculate_price_for_spoiled_turnips()
    {
        $turnips = TurnipsFactory::factory('壞掉的大頭菜', 100, 40);

        $this->assertEquals(0, $turnips->calculatePrice());
    }

    /**
     * 測試是否能夠收到未知的大頭菜。
     * 
     * @test
     */
    public function testException()
    {
        $this->expectException(InvalidArgumentException::class);

        TurnipsFactory::factory('未知的大頭菜', 0, 0);
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
- [技術部落格文章 - 靜態工廠](https://kantai235.github.io/StaticFactory)
- [靜態工廠 原始碼](https://github.com/Kantai235/php-design-pattern/master/DesignPatterns/Creational/StaticFactory)
- [靜態工廠 測試](https://github.com/Kantai235/php-design-pattern/master/Tests/Creational/StaticFactoryTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

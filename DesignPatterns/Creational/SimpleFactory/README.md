![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Creational/SimpleFactory/Banner.png)

# 簡單工廠 Simple Factory
簡單工廠，這是一種我們真的要買大頭菜的模式，你需要建立一個工廠，這個工廠負責生產特定物件，你只需要把材料丟給工廠，工廠就會把商品生產出來給你，你不需要理會工廠都在做些什麼，就有點像是你跟曹賣買大頭菜，你只需要付鈴錢就好，你不需要去理解曹賣到底是怎麼種大頭菜的。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Creational/SimpleFactory/UML.png)

## 實作
在建立大頭菜工廠之前，我們要先定義大頭菜出來，順便寫上一些功能，像是購買大頭菜、計算大頭菜的價格，這樣工廠才會知道自己要生產什麼。

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
     * @param int $price
     * @param int $count
     * 
     * @return int
     */
    public function buy(int $price, int $count): int
    {
        $this->price = $price;
        $this->count = $count;

        return $this->calculatePrice();
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

再來我們需要建立工廠，工廠會有個方法是建立大頭菜，並且回傳大頭菜。

TurnipsFactory.php
```php
/**
 * Class TurnipsFactory.
 */
class TurnipsFactory
{
    /**
     * @return Turnips
     */
    public function createTurnips(): Turnips
    {
        return new Turnips();
    }
}
```

## 測試
最後我們要寫個測試，測試的目的有幾個重要項目：
1. 測試是否能夠正常建立大頭菜。
2. 測試建立的大頭菜是否能夠用正常價格買入。
3. 測試建立的大頭菜是否能夠正常計算價格。
4. 測試建立的大頭菜如果沒有買過，那是不是能夠回傳 0 鈴錢。

SimpleFactoryTest.php
```php
/**
 * Class SimpleFactoryTest.
 */
class SimpleFactoryTest extends TestCase
{
    /**
     * 測試是否能夠正常建立大頭菜。
     * 
     * @test
     */
    public function test_can_create_turnip()
    {
        $turnips = (new TurnipsFactory())->createTurnips();

        $this->assertInstanceOf(Turnips::class, $turnips);
    }

    /**
     * 測試建立的大頭菜是否能夠用正常價格買入。
     * 
     * @test
     */
    public function test_can_buy_turnip()
    {
        $turnips = (new TurnipsFactory())->createTurnips();
        $price = $turnips->buy(100, 40);

        $this->assertEquals(4000, $price);
    }

    /**
     * 測試建立的大頭菜是否能夠正常計算價格。
     * 
     * @test
     */
    public function test_can_calculate_price()
    {
        $turnips = (new TurnipsFactory())->createTurnips();
        $turnips->buy(100, 40);
        $price = $turnips->calculatePrice();

        $this->assertEquals(4000, $price);
    }

    /**
     * 測試建立的大頭菜如果沒有買過，那是不是能夠回傳 0 鈴錢。
     * 
     * @test
     */
    public function test_can_calculate_price_error()
    {
        $turnips = (new TurnipsFactory())->createTurnips();

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
- [技術部落格文章 - 簡單工廠](https://kantai235.github.io/SimpleFactory)
- [簡單工廠 原始碼](https://github.com/Kantai235/php-design-pattern/tree/master/DesignPatterns/Creational/SimpleFactory)
- [簡單工廠 測試](https://github.com/Kantai235/php-design-pattern/tree/master/Tests/Creational/SimpleFactoryTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

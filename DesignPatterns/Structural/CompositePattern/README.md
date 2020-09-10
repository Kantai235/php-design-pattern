![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Structural/CompositePattern/Banner.png)

# 組合模式 Composite Pattern
組合模式，一種將物件一個一個處理，並且最後組合起來的模式，可以想像剛買到大頭菜時的夢想，經過每次漲跌所帶來的希望與絕望，究竟是充滿絕望的遞減型呢？還是致富關鍵的三期型呢？每次的價格異動，都代表著價格物件，最終賣出的鈴錢價格，是經過許多鈴錢價格物件所算出來的。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Structural/CompositePattern/UML.png)

## 實作
首先我們要先定義組合介面，用來套用在每個功能物件上。

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

再來建立大頭菜上漲(Price up)以及下跌(Price down)的物件，並且套用介面 Interface，其功能是把漲跌幅丟進去，用來紀錄當次的漲跌幅。

PriceUp.php
```php
/**
 * Class PriceUp.
 */
class PriceUp implements TurnipsInterface
{
    /**
     * @var int
     */
    protected $price;

    /**
     * PriceDown constructor.
     *
     * @param int $price
     */
    public function __construct(int $price)
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        return $this->price;
    }
}
```

PriceDown.php
```php
/**
 * Class PriceDown.
 */
class PriceDown implements TurnipsInterface
{
    /**
     * @var int
     */
    protected $price;

    /**
     * PriceDown constructor.
     *
     * @param int $price
     */
    public function __construct(int $price)
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        return - $this->price;
    }
}
```

最後建立大頭菜，賦予起始價格以及數量，然後可以賦予每次價格漲跌幅的物件，然後根據每個漲跌幅物件，來計算最終的鈴錢價格。

```php
/**
 * Class Turnips.
 */
class Turnips implements TurnipsInterface
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
     * @var TurnipsInterface[]
     */
    protected $elements = [];

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
        $_price = $this->price;
        foreach ($this->elements as $element) {
            $_price += $element->calculatePrice();
        }

        return $_price * $this->count;
    }

    /**
     * @param TurnipsInterface $element
     */
    public function addElement(TurnipsInterface $element)
    {
        array_push($this->elements, $element);
    }
}
```

## 測試
最後我們需要將大頭菜組合模式來寫些測試驗證一下，主要是測試鈴錢價格上漲物件、鈴錢價格下跌物件是否能夠正常運作，再來實際組裝起來再各別計算一次。
1. 測試鈴錢價格上漲物件是否能夠正常運作。
2. 測試鈴錢價格下跌物件是否能夠正常運作。
3. 測試鈴錢價格上漲物件、鈴錢價格下跌物件實際組裝起來再各別計算一次。

CompositePatternTest.php
```php
/**
 * Class CompositePatternTest.
 */
class CompositePatternTest extends TestCase
{
    /**
     * 測試鈴錢價格上漲物件是否能夠正常運作。
     * 
     * @test
     */
    public function test_price_up()
    {
        $price = new PriceUp(20);
        $this->assertEquals(20, $price->calculatePrice());
    }

    /**
     * 測試鈴錢價格下跌物件是否能夠正常運作。
     * 
     * @test
     */
    public function test_price_down()
    {
        $price = new PriceDown(20);
        $this->assertEquals(-20, $price->calculatePrice());
    }

    /**
     * 測試鈴錢價格上漲物件、鈴錢價格下跌物件實際組裝起來再各別計算一次。
     * 
     * @test
     */
    public function test_price_up_and_down()
    {
        $turnips = new Turnips(100, 40);
        $this->assertEquals(4000, $turnips->calculatePrice());

        $turnips->addElement(new PriceUp(20));
        $this->assertEquals(4800, $turnips->calculatePrice());

        $turnips->addElement(new PriceDown(30));
        $this->assertEquals(3600, $turnips->calculatePrice());
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

Time: 00:00.050, Memory: 6.00 MB

OK (34 tests, 81 assertions)
```

## 完整程式碼
[設計模式不難，找回快樂而已，以大頭菜為例。](https://github.com/Kantai235/php-design-pattern)
- [技術部落格文章 - 組合模式](https://kantai235.github.io/CompositePattern)
- [組合模式 原始碼](https://github.com/Kantai235/php-design-pattern/master/DesignPatterns/Structural/CompositePattern)
- [組合模式 測試](https://github.com/Kantai235/php-design-pattern/master/Tests/Structural/CompositePatternTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

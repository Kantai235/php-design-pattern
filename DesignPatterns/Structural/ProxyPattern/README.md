![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Structural/ProxyPattern/Banner.png)

# 代理模式 Proxy Pattern
代理模式，它可以作為需要被保護的物件的介面，若以檔案權限來比喻的話，就是對主要物件套上一層代理，你可以在代理上實作控制權限，像是其代理僅有讀取、執行的權限，並沒有刪除、修改的權限，並防止直接接觸實際物件，換作大頭菜來講的話，大頭菜的本質就是大頭菜，大頭菜就頂多提供數量堆積的功能，鈴錢的計算要在代理介面上實作。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Structural/ProxyPattern/UML.png)

## 實作
所以我們要先來實作大頭菜介面，並且僅提供大頭菜總數計算的功能。

TurnipsInterface.php
```php
/**
 * Interface TurnipsInterface.
 */
interface TurnipsInterface
{
    /**
     * @param int $count
     */
    public function setCount(int $count);

    /**
     * @return int
     */
    public function getCount(): int;
}
```

Turnips.php
```php
/**
 * Class Turnips.
 */
class Turnips implements TurnipsInterface
{
    /**
     * @var int
     */
    protected int $count = 0;

    /**
     * @param int $count
     */
    public function setCount(int $count)
    {
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }
}
```

最後我們要製作大頭菜的代理，大頭菜代理繼承了大頭菜，並且再額外提供了鈴錢價格計算的功能。

TurnipsProxy.php
```php
/**
 * Class TurnipsProxy.
 */
class TurnipsProxy extends Turnips implements TurnipsInterface
{
    /**
     * @var int
     */
    protected int $price = 0;

    /**
     * @var int
     */
    protected ?int $total = null;

    /**
     * TurnipsProxy constructor.
     * 
     * @param int $price
     * @param int $count
     */
    public function __construct(int $price, int $count)
    {
        $this->setPrice($price);
        $this->setCount($count);
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price)
    {
        $this->price = $price;
    }
    
    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function calculateTotal(): int
    {
        if ($this->total === null)
        {
            $this->total = $this->getPrice() * $this->getCount();
        }

        return $this->total;
    }
}
```

## 測試
最後我們要來測試代理大頭菜的功能，會有幾個大項目需要測試：
1. 透過代理來計算鈴錢總價。
2. 鈴錢總價只會計算一次，並不會因為後續更改而變更。

ProxyPatternTest.php
```php
/**
 * Class ProxyPatternTest.
 */
class ProxyPatternTest extends TestCase
{
    /**
     * 透過代理來計算鈴錢總價。
     * 
     * @test
     */
    public function test_proxy_calculate_price()
    {
        $turnips = new TurnipsProxy(100, 40);
        $this->assertEquals(4000, $turnips->calculateTotal());
    }

    /**
     * 透過代理來計算鈴錢總價，並且鈴錢總價只會計算一次，並不會因為後續更改而變更。
     * 
     * @test
     */
    public function test_proxy_will_only_execute_calculate_price_once()
    {
        $turnips = new TurnipsProxy(100, 40);
        $this->assertEquals(4000, $turnips->calculateTotal());

        $turnips->setPrice(200);
        $turnips->setCount(30);
        $this->assertEquals(4000, $turnips->calculateTotal());
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
 ==> DependencyInjectionTest    ✔  ✔  ✔  
 ==> FacadePatternTest          ✔  
 ==> FluentInterfaceTest        ✔  
 ==> FlyweightPatternTest       ✔  
 ==> ProxyPatternTest           ✔  ✔  

Time: 00:00.029, Memory: 6.00 MB

OK (46 tests, 110 assertions)
```

## 完整程式碼
[設計模式不難，找回快樂而已，以大頭菜為例。](https://github.com/Kantai235/php-design-pattern)
- [技術部落格文章 - 代理模式](https://kantai235.github.io/ProxyPattern)
- [代理模式 原始碼](https://github.com/Kantai235/php-design-pattern/master/DesignPatterns/Structural/ProxyPattern)
- [代理模式 測試](https://github.com/Kantai235/php-design-pattern/master/Tests/Structural/ProxyPatternTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

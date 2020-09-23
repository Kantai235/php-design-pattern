![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Structural/FluentInterface/Banner.png)

# 流暢介面 Fluent Interface
流暢介面，常用於撰寫如同文章般容易閱讀的程式碼，如果以大頭菜來講，那麼在建立大頭菜的同時，希望可以順便賦予其鈴錢價格、數量，並且最終獲得的依舊是大頭菜物件。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Structural/FluentInterface/UML.png)

## 實作
這次只需要實作一個大頭菜物件，其精隨在於賦予鈴錢價格、數量時，最後會將整個物件再回傳出來，透過被呼叫的方法來回傳當前物件。

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
    protected $price = 0;

    /**
     * @var int
     */
    protected $count = 0;

    /**
     * @param int $price
     * 
     * @return Turnips
     */
    public function price(int $price): Turnips
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @param int $count
     * 
     * @return Turnips
     */
    public function count(int $count): Turnips
    {
        $this->count = $count;

        return $this;
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

## 測試
我們要來實際測試大頭菜是否能夠以流暢介面的方式來建立物件，並且計算鈴錢總價。

FluentInterfaceTest.php
```php
/**
 * Class FluentInterfaceTest.
 */
class FluentInterfaceTest extends TestCase
{
    /**
     * @test
     */
    public function test_build_turnips()
    {
        $turnips = (new Turnips())
            ->price(100)
            ->count(40);

        $this->assertEquals(4000, $turnips->calculatePrice());
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

Time: 00:00.079, Memory: 6.00 MB

OK (43 tests, 94 assertions)
```

## 完整程式碼
[設計模式不難，找回快樂而已，以大頭菜為例。](https://github.com/Kantai235/php-design-pattern)
- [技術部落格文章 - 流暢介面](https://kantai235.github.io/FluentInterface)
- [流暢介面 原始碼](https://github.com/Kantai235/php-design-pattern/tree/master/DesignPatterns/Structural/FluentInterface)
- [流暢介面 測試](https://github.com/Kantai235/php-design-pattern/tree/master/Tests/Structural/FluentInterfaceTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

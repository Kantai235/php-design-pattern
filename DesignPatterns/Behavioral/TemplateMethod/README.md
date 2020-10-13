![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/TemplateMethod/Banner.png)

# 模板方法 Template Method
模板方法，是一種如果這包水泥我有、你也有，就連喬瑟夫都有，那我們就應該把這八百包水泥抽離出來的設計模式，是設計模式中很簡單的模式，在模板(Template)裡頭會定義需要實作的方法，並且由繼承物件去實作或複寫，這個設計模式適用於不同物件有多處相似功能的時候，可以減少物件的耦合性過高問題。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/TemplateMethod/UML.png)

## 實作
首先我們會需要建立一個抽象的模板，並且提供大頭菜無論健康的、壞掉的都擁有的方法，像是獲得鈴錢價格(getPrice)、獲得數量(getCount)以及計算總計鈴錢價格(calculatePrice)，而有些方法需要繼承物件去實作的，例如設定鈴錢價格(setPrice)，我們就需要以抽象方法的方式去定義，讓繼承物件必須去實作。

TurnipsTemplate.php
```php
/**
 * Abstract TurnipsTemplate.
 */
abstract class TurnipsTemplate
{
    /**
     * @var int
     */
    protected int $price = 0;

    /**
     * @var int
     */
    protected int $count = 0;

    /**
     * TurnipsTemplate constructor.
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
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param int $price
     */
    abstract public function setPrice(int $price);

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
    public function calculatePrice(): int
    {
        $price = $this->price;
        $count = $this->count;
        return $price * $count;
    }
}
```

再來我們開始建立物件去繼承模板，首先健康的大頭菜，在設定鈴錢價格時，就直接根據設定的鈴錢金額去如實設定。

Turnips.php
```php
/**
 * Class Turnips.
 */
class Turnips extends TurnipsTemplate
{
    /**
     * @param int $price
     */
    public function setPrice(int $price)
    {
        $this->price = $price;
    }
}
```

而壞掉的大頭菜部分，則是無論設定的鈴錢金額是多少，都要直接給予 0 鈴錢，因為壞掉的大頭菜不值任何鈴錢。

Spoiled.php
```php
/**
 * Class Spoiled.
 */
class Spoiled extends TurnipsTemplate
{
    /**
     * @param int $price
     */
    public function setPrice(int $price)
    {
        $this->price = 0;
    }
}
```

## 測試
最終我們要測試大頭菜的模板所建構出來的大頭菜物件是否可以正常運作，我們會有兩個測試，分別是測試健康的大頭菜物件(Turnips)以及壞掉的大頭菜物件(Spoiled)。

TemplateMethodTest.php
```php
/**
 * Class TemplateMethodTest.
 */
class TemplateMethodTest extends TestCase
{
    /**
     * @test
     */
    public function test_turnips_template()
    {
        $turnips = new Turnips(100, 40);

        $this->assertEquals(100, $turnips->getPrice());
        $this->assertEquals(40, $turnips->getCount());
        $this->assertEquals(4000, $turnips->calculatePrice());
    }

    /**
     * @test
     */
    public function test_spoiled_template()
    {
        $turnips = new Spoiled(100, 40);

        $this->assertEquals(0, $turnips->getPrice());
        $this->assertEquals(40, $turnips->getCount());
        $this->assertEquals(0, $turnips->calculatePrice());
    }
}
```

最後測試的執行結果會獲得如下：

```
PHPUnit Pretty Result Printer 0.28.0 by Codedungeon and contributors.
==> Configuration: ~/php-design-pattern/vendor/codedungeon/phpunit-result-printer/src/phpunit-printer.yml

PHPUnit 9.2.6 by Sebastian Bergmann and contributors.


 ==> ...fResponsibilitiesTest   ✔  ✔  ✔  
 ==> CommandPatternTest         ✔  
 ==> IteratorPatternTest        ✔  ✔  ✔  ✔  
 ==> MediatorPatternTest        ✔  ✔  ✔  
 ==> MementoPatternTest         ✔  
 ==> NullObjectPatternTest      ✔  ✔  ✔  ✔  
 ==> ObserverPatternTest        ✔  
 ==> SpecificationPatternTest   ✔  ✔  ✔  ✔  
 ==> StatePatternTest           ✔  
 ==> StrategyPatternTest        ✔  
 ==> TemplateMethodTest         ✔  ✔  
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
 ==> RegistryPatternTest        ✔  ✔  ✔  ✔  ✔  

Time: 00:00.052, Memory: 8.00 MB

OK (76 tests, 153 assertions)
```

## 完整程式碼
[設計模式不難，找回快樂而已，以大頭菜為例。](https://github.com/Kantai235/php-design-pattern)
- [技術部落格文章 - 模板方法](https://kantai235.github.io/TemplateMethod)
- [模板方法 原始碼](https://github.com/Kantai235/php-design-pattern/tree/master/DesignPatterns/Behavioral/TemplateMethod)
- [模板方法 測試](https://github.com/Kantai235/php-design-pattern/tree/master/Tests/Behavioral/TemplateMethodTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

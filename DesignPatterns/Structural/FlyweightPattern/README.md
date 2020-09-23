![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Structural/FlyweightPattern/Banner.png)

# 享元模式 Flyweight Pattern
享元模式，在定義上來說是共享物件，將相似的物件集中整理，減少記憶體上的使用，舉例來說每座島的大頭菜鈴錢價格都不同，有些朋友會送你大頭菜，但因為朋友太多了，所以需要有個地方集中放這些大頭菜，並且記錄起來，每個朋友都送你一組大頭彩，但你不能重複紀錄，不然你只收到一組大頭菜，帳上卻紀錄兩組，這樣就不好了。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Structural/FlyweightPattern/UML.png)

## 實作
首先我們須要先定義大頭菜作為共享目標，紀錄了島嶼、鈴錢以及數量，並且提供了簡單的計算總價方法。

FlyweightInterface.php
```php
/**
 * Interface FlyweightInterface.
 */
interface FlyweightInterface
{
    /**
     * @return int
     */
    public function calculatePrice(): int;
}
```

```php
/**
 * Class TurnipsFlyweight.
 */
class TurnipsFlyweight implements FlyweightInterface
{
    /**
     * @var string
     */
    protected $island;

    /**
     * @var int
     */
    protected $price;

    /**
     * @var int
     */
    protected $count;

    /**
     * @param string $island
     * @param int $price
     * @param int $count
     */
    public function __construct(string $island, int $price, int $count)
    {
        $this->island = $island;
        $this->price = $price;
        $this->count = $count;
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

再來製作享元工廠，主要負責建立、管理大頭菜共享物件，以及提供基本功能，例如計算全部大頭菜總鈴錢的方法。

FlyweightFactory.php
```php
use Countable;

/**
 * Class FlyweightFactory.
 */
class FlyweightFactory implements Countable
{
    /**
     * @var TurnipsFlyweight[]
     */
    protected $turnips = [];

    /**
     * @param string $island
     * @param int $price
     * @param int $count
     */
    public function get(string $island, int $price = 0, int $count = 0): TurnipsFlyweight
    {
        if (!isset($this->turnips[$island])) {
            $this->turnips[$island] = new TurnipsFlyweight($island, $price, $count);
        }

        return $this->turnips[$island];
    }

    /**
     * @return int
     */
    public function calculateTotal(): int
    {
        $total = 0;
        foreach ($this->turnips as $turnip) {
            $total += $turnip->calculatePrice();
        }

        return $total;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->turnips);
    }
}
```

## 額外補充
### Countable
繼承 `Countable` 這個類別可以使用 `count()` 這個方法，因此需要實作它。
```php
class Countable {
    /* Methods */
    abstract public count ( void ) : int
}
```
- 官方文件：[PHP: Countable - Manual](https://www.php.net/manual/en/class.countable.php)

## 測試
最後我們要對享元物件、工廠進行簡單的測試，假設我們已經擁有了許多大頭菜，那麼我們有幾個需要做的檢查事項：
1. 依序塞入享元，並且計算該次塞入的大頭菜跟紀錄所算出來的鈴錢是否相符。
2. 大頭菜全部塞入後，所存入的筆數是否跟實際上相符。
3. 最後計算所有大頭菜的總鈴錢是否是正確的。

FlyweightPatternTest.php
```php
/**
 * Class FlyweightPatternTest.
 */
class FlyweightPatternTest extends TestCase
{
    /**
     * @var array
     */
    protected $turnips = array(
        'Island_A' => array('price' => 90, 'count' => 40),
        'Island_B' => array('price' => 92, 'count' => 36),
        'Island_C' => array('price' => 94, 'count' => 32),
        'Island_D' => array('price' => 96, 'count' => 28),
        'Island_E' => array('price' => 98, 'count' => 24),
        'Island_F' => array('price' => 100, 'count' => 20),
        'Island_G' => array('price' => 102, 'count' => 16),
        'Island_H' => array('price' => 104, 'count' => 12),
        'Island_I' => array('price' => 106, 'count' => 8),
        'Island_J' => array('price' => 108, 'count' => 4),
        'Island_K' => array('price' => 110, 'count' => 40),
    );

    /**
     * @test
     */
    public function test_flyweight()
    {
        $factory = new FlyweightFactory();

        foreach ($this->turnips as $key => $value) {
            $flyweight = $factory->get($key, $value['price'], $value['count']);
            $total = $flyweight->calculatePrice();

            $this->assertEquals($value['price'] * $value['count'], $total);
        }

        $this->assertCount(count($this->turnips), $factory);
        $this->assertEquals(25520, $factory->calculateTotal());
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

Time: 00:00.030, Memory: 6.00 MB

OK (44 tests, 107 assertions)
```

## 完整程式碼
[設計模式不難，找回快樂而已，以大頭菜為例。](https://github.com/Kantai235/php-design-pattern)
- [技術部落格文章 - 享元模式](https://kantai235.github.io/FlyweightPattern)
- [享元模式 原始碼](https://github.com/Kantai235/php-design-pattern/tree/master/DesignPatterns/Structural/FlyweightPattern)
- [享元模式 測試](https://github.com/Kantai235/php-design-pattern/tree/master/Tests/Structural/FlyweightPatternTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

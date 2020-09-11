![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/IteratorPattern/Banner.png)

# 疊代器模式 Iterator Pattern
疊代器模式，提供一種方法來簡單控制一個集合物件，這段過程並不會暴露該物件的來源或修改它，就有點像是你的背包(Bag)一樣，疊代器(Iterator)可以簡單控制你背包中的大頭菜(Turnips)以及鈴錢(Bells)。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/IteratorPattern/UML.png)

## 實作
首先我們一樣要先建立大頭菜物件(Turnips)，並且賦予一些簡單方法，像是島嶼(Island)、鈴錢價格(Price)及數量(Count)，並且提供簡單的取得(get)及賦予(set)方法。

Turnips.php
```php
/**
 * Class Turnips.
 */
class Turnips
{
    /**
     * @var string
     */
    protected string $island;

    /**
     * @var int
     */
    protected int $price;

    /**
     * @var int
     */
    protected int $count;

    /**
     * Turnips constructor.
     * 
     * @param string $island
     * @param int $price
     * @param int $count
     */
    public function __construct(string $island, int $price, int $count)
    {
        $this->setIsland($island);
        $this->setPrice($price);
        $this->setCount($count);
    }

    /**
     * @param string $island
     */
    public function setIsland(string $island)
    {
        $this->island = $island;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price)
    {
        $this->price = $price;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count)
    {
        $this->count = $count;
    }

    /**
     * @return string
     */
    public function getIsland(): string
    {
        return $this->island;
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
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        return $this->getPrice() * $this->getCount();
    }
}
```

再來我們要建立背包(Bag)來負責管理大頭菜這個集合，這裡比較特別的是我們要實作 `Countable` 以及 `Iterator` 這兩個介面，讓背包可以直接提供 Count 方法、陣列 Array 相關方法。

Bag.php
```php
use Countable;
use Iterator;

/**
 * Class Bag.
 */
class Bag implements Countable, Iterator
{
    /**
     * @var Turnips[]
     */
    protected array $turnips = [];

    /**
     * @var int
     */
    protected int $currentIndex = 0;

    /**
     * @param Turnips
     */
    public function addTurnips(Turnips $turnips)
    {
        $this->turnips[] = $turnips;
    }

    /**
     * @param Turnips
     */
    public function removeTurnips(Turnips $turnipsToRemove)
    {
        foreach ($this->turnips as $key => $turnip) {
            if ($turnip->getIsland() === $turnipsToRemove->getIsland()) {
                unset($this->turnips[$key]);
            }
        }

        $this->turnips = array_values($this->turnips);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->turnips);
    }

    /**
     * @return Turnips
     */
    public function current(): Turnips
    {
        return $this->turnips[$this->currentIndex];
    }

    /**
     * @return int
     */
    public function key(): int
    {
        return $this->currentIndex;
    }

    /**
     * @return void
     */
    public function next()
    {
        $this->currentIndex++;
    }

    /**
     * @return void
     */
    public function rewind()
    {
        $this->currentIndex = 0;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->turnips[$this->currentIndex]);
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

### Iterator
繼承 `Iterator` 這個類別可以使用 `current()`、`key()`、`next()`、`rewind()`、`valid()` 這些方法，因此需要實作它們。
```php
class Iterator extends Traversable {
    /* Methods */
    abstract public current ( void ) : mixed
    abstract public key ( void ) : scalar
    abstract public next ( void ) : void
    abstract public rewind ( void ) : void
    abstract public valid ( void ) : bool
}
```
- 官方文件：[PHP: Iterator - Manual](https://www.php.net/manual/en/class.iterator.php)

## 測試

IteratorPatternTest.php
```php
/**
 * Class IteratorPatternTest.
 */
class IteratorPatternTest extends TestCase
{
    /**
     * @test
     */
    public function test_can_iterate_over_bag()
    {
        $bag = new Bag();
        $bag->addTurnips(new Turnips('Island_A', 100, 40));
        $bag->addTurnips(new Turnips('Island_B', 90, 40));
        $bag->addTurnips(new Turnips('Island_C', 80, 40));

        $islands = [];

        foreach ($bag as $turnips) {
            $islands[] = $turnips->getIsland();
        }

        $this->assertSame(
            array(
                'Island_A',
                'Island_B',
                'Island_C'
            ),
            $islands
        );
    }

    /**
     * @test
     */
    public function test_can_iterate_over_bag_after_removing_turnips()
    {
        $turnipsA = new Turnips('Island_A', 100, 40);
        $turnipsB = new Turnips('Island_B', 200, 10);

        $bag = new Bag();
        $bag->addTurnips($turnipsA);
        $bag->addTurnips($turnipsB);
        $bag->removeTurnips($turnipsA);

        $islands = [];
        foreach ($bag as $turnips) {
            $islands[] = $turnips->getIsland();
        }

        $this->assertSame(
            array('Island_B'),
            $islands
        );
    }

    /**
     * @test
     */
    public function test_can_add_turnips_to_bag()
    {
        $turnips = new Turnips('Island_A', 100, 40);

        $bag = new Bag();
        $bag->addTurnips($turnips);

        $this->assertCount(1, $bag);
    }

    /**
     * @test
     */
    public function test_can_remove_turnips_from_bag()
    {
        $turnips = new Turnips('Island_A', 100, 40);

        $bag = new Bag();
        $bag->addTurnips($turnips);
        $bag->removeTurnips($turnips);

        $this->assertCount(0, $bag);
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

Time: 00:00.117, Memory: 6.00 MB

OK (59 tests, 126 assertions)
```

## 完整程式碼
[設計模式不難，找回快樂而已，以大頭菜為例。](https://github.com/Kantai235/php-design-pattern)
- [技術部落格文章 - 疊代器模式](https://kantai235.github.io/IteratorPattern)
- [疊代器模式 原始碼](https://github.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/IteratorPattern)
- [疊代器模式 測試](https://github.com/Kantai235/php-design-pattern/master/Tests/Behavioral/IteratorPatternTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

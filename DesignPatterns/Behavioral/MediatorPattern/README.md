![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/MediatorPattern/Banner.png)

# 中介者模式 Mediator Pattern
中介者模式，在兩個不同的封裝物件之間，作為中間進行交互的模式，可以減少物件之間的依賴關係，並且降低耦合性問題，舉例來說有背包(Bag)與商店(Store)這兩個物件，你會從背包(Bag)當中拿出鈴錢(Bells)去商店(Store)購買大頭菜(Turnips)，但它們應該要各自其職，不要太過於互相依賴，因此你會需要有個中間控制這些物件的中介者(Mediator)。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/MediatorPattern/UML.png)

## 實作
首先我們不外乎先製作出大頭菜(Turnips)物件，只需要賦予簡單計算數量的功能即可。

Turnips.php
```php
/**
 * Turnips
 */
class Turnips
{
    /**
     * @var int
     */
    protected int $count;

    /**
     * Turnips constructor.
     * 
     * @param int $count
     */
    public function __construct(int $count)
    {
        $this->setCount($count);
    }

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

接下來我們要做出背包(Bag)以及商店(Store)這兩個物件，因為這兩個物件會進行交互，所以需要有一個抽象類別去把中介者(Mediator)帶入，這裡稱之為協調同事(Colleague)物件，所以我們要先實作出協調同事(Colleague)這項物件，再去實作背包(Bag)以及商店(Store)這兩個物件，並且繼承協調同事(Colleague)這個抽象。

Colleague.php
```php
/**
 * Abstract Colleague.
 */
abstract class Colleague
{
    /**
     * @var Mediator
     */
    protected Mediator $mediator;

    /**
     * @param Mediator $mediator
     */
    public function setMediator(Mediator $mediator)
    {
        $this->mediator = $mediator;
    }
}
```

Bag.php
```php
/**
 * Class Bag.
 */
class Bag extends Colleague
{
    /**
     * @var Bells
     */
    protected $bells;

    /**
     * @var Turnips
     */
    protected $turnips;

    /**
     * Bag constructor.
     */
    public function __construct()
    {
        $this->bells = new Bells(0);
        $this->turnips = new Turnips(0);
    }

    /**
     * @return int
     */
    public function getBells(): int
    {
        return $this->bells->getBells();
    }

    /**
     * @return int
     */
    public function getTurnips(): int
    {
        return $this->turnips->getCount();
    }

    /**
     * @param int $bells
     */
    public function setBells(int $bells)
    {
        echo "[背包] 剩下 $bells 鈴錢。";
        $this->bells->setBells($bells);
    }

    /**
     * @param int $count
     */
    public function setTurnips(int $count)
    {
        echo "[背包] 剩下 $count 顆大頭菜。";
        $this->turnips->setCount($count);
    }
}
```

Store.php
```php
use InvalidArgumentException;

/**
 * Class Store.
 */
class Store extends Colleague
{
    /**
     * @param int $price
     * @param int $count
     * 
     * @throws InvalidArgumentException
     * @return Turnips
     */
    public function buyTurnips(int $price, int $count)
    {
        $total = $price * $count;
        if ($this->mediator->getBells() >= $total) {
            /**
             * 跟商店(Store)買大頭菜(Turnips)，並且將大頭菜放入背包(Bag)當中。
             */
            $this->mediator->setBells($this->mediator->getBells() - $total);
            echo "[商店] 收到了 $total 鈴錢。";

            echo "[商店] 賣出了 $count 顆大頭菜。";
            $this->mediator->setTurnips($this->mediator->getTurnips() + $count);

            return;
        }

        throw new InvalidArgumentException('[錯誤] 您背包裡的鈴錢不足，無法購買大頭菜。');
    }

    /**
     * @param int $price
     * @param int $count
     * 
     * @throws InvalidArgumentException
     * @return int
     */
    public function sellTurnips(int $price, int $count)
    {
        if ($this->mediator->getTurnips() >= $count) {
            /**
             * 跟商店(Store)賣大頭菜(Turnips)，並且將鈴錢放入背包(Bag)當中。
             */
            $this->mediator->setTurnips($this->mediator->getTurnips() - $count);
            echo "[商店] 收購了 $count 顆大頭菜。";

            $total = $price * $count;
            echo "[商店] 支出了 $total 鈴錢。";
            $this->mediator->setBells($this->mediator->getBells() + $total);

            return;
        }

        throw new InvalidArgumentException('[錯誤] 您背包裡的大頭菜不足，無法販賣大頭菜。');
    }
}
```

最後我們要來把中介者(Mediator)實作出來，這個中介者(Mediator)會作為背包(Bag)以及商店(Store)之間交互的載體，所以在實作之前先定義它的介面(Interface)出來。

MediatorInterface.php
```php
/**
 * Interface MediatorInterface.
 */
interface MediatorInterface
{
    /**
     * @return int
     */
    public function getBells(): int;

    /**
     * @return int
     */
    public function getTurnips(): int;

    /**
     * @param int $bells
     */
    public function setBells(int $bells);
    
    /**
     * @param int $count
     */
    public function setTurnips(int $count);

    /**
     * @param int $price
     * @param int $count
     */
    public function buyTurnips(int $price, int $count);

    /**
     * @param int $price
     * @param int $count
     */
    public function sellTurnips(int $price, int $count);
}
```

最後去實作出背包(Bag)與商店(Store)的中介者(Mediator)，背包(Bag)主要控制鈴錢(Bells)以及大頭菜(Turnips)，商店(Store)則是會透過中介者(Mediator)去向背包(Bag)去索取鈴錢(Bells)以及大頭菜(Turnips)，而不是真的去觸及背包(Bag)，減少物件之間的依賴關係。

BagStoreMediator.php
```php
use InvalidArgumentException;

/**
 * Class BagStoreMediator.
 */
class BagStoreMediator implements MediatorInterface
{
    /**
     * @var Bag
     */
    protected Bag $bag;

    /**
     * @var Store
     */
    protected Store $store;

    /**
     * BagStoreMediator constructor.
     * 
     * @param Bag $bag
     * @param Store $store
     */
    public function __construct(Bag $bag, Store $store)
    {
        $this->bag = $bag;
        $this->store = $store;

        $this->bag->setMediator($this);
        $this->store->setMediator($this);
    }

    /**
     * @return int
     */
    public function getBells(): int
    {
        return $this->bag->getBells();
    }

    /**
     * @return int
     */
    public function getTurnips(): int
    {
        return $this->bag->getTurnips();
    }

    /**
     * @param int $bells
     */
    public function setBells(int $bells)
    {
        $this->bag->setBells($bells);
    }

    /**
     * @param int $count
     */
    public function setTurnips(int $count)
    {
        $this->bag->setTurnips($count);
    }

    /**
     * @param int $price
     * @param int $count
     * 
     * @throws InvalidArgumentException
     */
    public function buyTurnips(int $price, int $count)
    {
        $total = $price * $count;
        if ($this->bag->getBells() >= $total) {
            echo "[玩家] 您購買了 $count 顆大頭菜，每顆單價 $price 鈴錢，總共 $total 鈴錢。";
            $this->store->buyTurnips($price, $count);

            return;
        }

        throw new InvalidArgumentException('[錯誤] 您的大頭菜不足，無法購買大頭菜。');
    }

    /**
     * @param int $price
     * @param int $count
     * 
     * @throws InvalidArgumentException
     */
    public function sellTurnips(int $price, int $count)
    {
        $total = $price * $count;
        if ($this->bag->getTurnips() >= $count) {
            echo "[玩家] 您販賣了 $count 顆大頭菜，每顆單價 $price 鈴錢，總共 $total 鈴錢。";
            $this->store->sellTurnips($price, $count);

            return;
        }

        throw new InvalidArgumentException('[錯誤] 您的大頭菜不足，無法販賣大頭菜。');
    }
}
```

## 測試
最後根據上面的中介者，我們要做幾個簡單的測試，第一件事是測試進行買賣大頭菜時，所產生的 Log 順序、資料是否正確，其次是例外錯誤 InvalidArgumentException 是否有確實。

MediatorPatternTest.php
```php
/**
 * Class MediatorPatternTest.
 */
class MediatorPatternTest extends TestCase
{
    /**
     * @test
     */
    public function test_buy_and_sell_turnips()
    {
        $mediator = new BagStoreMediator(new Bag(), new Store());
        $mediator->setBells(10000);

        $this->expectOutputString(implode(array(
            "[背包] 剩下 10000 鈴錢。",
            "[玩家] 您購買了 40 顆大頭菜，每顆單價 100 鈴錢，總共 4000 鈴錢。",
            "[背包] 剩下 6000 鈴錢。",
            "[商店] 收到了 4000 鈴錢。",
            "[商店] 賣出了 40 顆大頭菜。",
            "[背包] 剩下 40 顆大頭菜。",
            "[玩家] 您販賣了 20 顆大頭菜，每顆單價 200 鈴錢，總共 4000 鈴錢。",
            "[背包] 剩下 20 顆大頭菜。",
            "[商店] 收購了 20 顆大頭菜。",
            "[商店] 支出了 4000 鈴錢。",
            "[背包] 剩下 10000 鈴錢。",
        )));

        $mediator->buyTurnips(100, 40);
        $mediator->sellTurnips(200, 20);
    }

    /**
     * @test
     */
    public function test_buy_turnips_overflow()
    {
        $this->expectException(InvalidArgumentException::class);

        $mediator = new BagStoreMediator(new Bag(), new Store());
        $mediator->buyTurnips(100, 200);
    }

    /**
     * @test
     */
    public function test_sell_turnips_overflow()
    {
        $this->expectException(InvalidArgumentException::class);

        $mediator = new BagStoreMediator(new Bag(), new Store());
        $mediator->sellTurnips(100, 40);
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

Time: 00:00.173, Memory: 6.00 MB

OK (62 tests, 129 assertions)
```

## 完整程式碼
[設計模式不難，找回快樂而已，以大頭菜為例。](https://github.com/Kantai235/php-design-pattern)
- [技術部落格文章 - 中介者模式](https://kantai235.github.io/MediatorPattern)
- [中介者模式 原始碼](https://github.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/MediatorPattern)
- [中介者模式 測試](https://github.com/Kantai235/php-design-pattern/master/Tests/Behavioral/MediatorPatternTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

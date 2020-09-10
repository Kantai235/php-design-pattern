![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Structural/FacadePattern/Banner.png)

# 外觀模式 Facade Pattern
外觀模式，或者稱作門面模式，一種把複雜邏輯給包裝起來的一種模式，舉個例子來說，今天已經不單只是計算大頭菜了，而是你有個背包(Bag)要先放入鈴錢(Bells)，然後拿出鈴錢從曹賣(DaisyMae)手中購買大頭菜，並且把大頭菜賣給 Nook 商店(Store)，牽涉到許多的細節，透過外觀模式來將複雜的操作集中成幾個簡單的動作。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Structural/FacadePattern/UML.png)

## 實作
首先我們先慣例定義一下主角大頭菜(Turnips)，在這邊只需要給予價格、數量即可。

Turnips.php
```php
/**
 * Class Turnips
 */
class Turnips
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
    public function setPrice(int $price)
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function setCount(int $count)
    {
        $this->count = $count;
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
}
```

接下來我們要定義背包(Bag)，會需要可以放入鈴錢、大頭菜，並且可以取用，在取出的同時必須做到扣除背包裡鈴錢或大頭菜的數量。

BagInterface.php
```php
/**
 * Interface BagInterface.
 */
interface BagInterface
{
    /** 
     * @param int $bells
     */
    public function setBells(int $bells): int;

    /** 
     * @return int
     */
    public function getBells(int $bells): int;

    /** 
     * @param Turnips $turnips
     */
    public function setTurnips(Turnips $turnips): Turnips;

    /** 
     * @return Turnips
     */
    public function getTurnips(int $count): Turnips;
}
```

Bag.php
```php
/**
 * Class Bag.
 */
class Bag implements BagInterface
{
    /**
     * @var int
     */
    protected $bells = 0;

    /**
     * @var Turnips
     */
    protected $turnips;

    /** 
     * @param int $bells
     */
    public function setBells(int $bells): int
    {
        $this->bells += $bells;

        return $this->bells;
    }

    /** 
     * @return int
     */
    public function getBells(int $bells): int
    {
        if ($this->bells >= $bells) {
            $this->bells -= $bells;
            return $this->bells;
        }

        throw new \InvalidArgumentException('背包裡頭沒有那麼多的鈴錢。');
    }

    /** 
     * @param Turnips
     */
    public function setTurnips(Turnips $turnips): Turnips
    {
        $this->turnips = $turnips;

        return $this->turnips;
    }

    /** 
     * @return Turnips
     */
    public function getTurnips(int $count): Turnips
    {
        if ($this->turnips->getCount() >= $count) {
            $newCount = $this->turnips->getCount() - $count;
            $this->turnips->setCount($newCount);

            return new Turnips($this->turnips->getPrice(), $count);
        }

        throw new \InvalidArgumentException('背包裡頭沒有那麼多的大頭菜。');
    }
}
```

再來我們要定義曹賣(DaisyMae)，曹賣的功能很簡單，就只需要購買大頭菜即可，當玩家購買大頭菜時，曹賣必須給玩家大頭菜。

DaisyMaeInterface.php
```php
/**
 * Interface DaisyMaeInterface.
 */
interface DaisyMaeInterface
{
    /** 
     * @param int $price
     * @param int $count
     * 
     * @return Turnips
     */
    public function buy(int $price, int $count): Turnips;
}
```

DaisyMae.php
```php
/**
 * Class DaisyMae.
 */
class DaisyMae implements DaisyMaeInterface
{
    /** 
     * @param int $price
     * @param int $count
     * 
     * @return Turnips
     */
    public function buy(int $price, int $count): Turnips
    {
        return new Turnips($price, $count);
    }
}
```

再來我們需要建立 Nook 商店(Store)，商店的功能也很簡單，就是把大頭菜賣給商店就可以了。

StoreInterface.php
```php
/**
 * Interface StoreInterface.
 */
interface StoreInterface
{
    /**
     * @param Turnips $turnips
     * @param int          $price
     * 
     * @return int
     */
    public function sell(Turnips $turnips, int $price): int;
}
```

Store.php
```php
/**
 * Class Store.
 */
class Store implements StoreInterface
{
    /**
     * @param Turnips $turnips
     * @param int          $price
     * 
     * @return int
     */
    public function sell(Turnips $turnips, int $price): int
    {
        return $turnips->getCount() * $price;
    }
}
```

最後我們需要來建立外觀(Facade)，其功能是負責處理複雜邏輯，將其化為簡單的動作，這裡我們需要幾個簡單的動作，分別是：
1. 在背包裡放入鈴錢。
2. 向曹賣購買大頭菜。
3. 向 Nook 商店販賣大頭菜。
4. 從背包裡取出鈴錢。

Facade.php
```php
/**
 * Class Facade.
 */
class Facade
{
    /**
     * @var BagInterface
     */
    protected $bag;

    /**
     * @var StoreInterface
     */
    protected $store;

    /**
     * @var DaisyMaeInterface
     */
    protected $daisyMae;

    /**
     * Facade constructor.
     * 
     * @param BagInterface $bag
     * @param StoreInterface $store
     * @param DaisyMaeInterface $daisyMae
     */
    public function __construct(BagInterface $bag, StoreInterface $store, DaisyMaeInterface $daisyMae)
    {
        $this->bag = $bag;
        $this->store = $store;
        $this->daisyMae = $daisyMae;
    }

    /**
     * @param int $bells
     */
    public function takeupBells(int $bells): int
    {
        return $this->bag->setBells($bells);
    }

    /**
     * @param int $bells
     * 
     * @return int
     */
    public function takeoutBells(int $bells): int
    {
        return $this->bag->getBells($bells);
    }

    /**
     * @param int $price
     * @param int $count
     * 
     * @return int
     */
    public function buyTurnips(int $price, int $count): int
    {
        $this->bag->getBells($price * $count);
        $turnips = $this->daisyMae->buy($price, $count);
        $this->bag->setTurnips($turnips);

        return $this->bag->setBells(0);
    }

    /**
     * @param int $price
     * 
     * @return int
     */
    public function sellTurnips(int $price, int $count): int
    {
        $turnips = $this->bag->getTurnips($count);
        $bells = $this->store->sell($turnips, $price);
        return $this->bag->setBells($bells);
    }
}
```

## 測試
撰寫完外觀模式後，我們需要測試程式邏輯是否正確，因此接下來也會有幾個大項目需要測試：
1. 在背包裡塞入 10,000 鈴錢。
2. 購買 40 顆單價 100 鈴錢的大頭菜。
3. 以 400 鈴錢賣出 20 顆大頭菜。
4. 從背包拿出 10,000 鈴錢。
5. 再以 600 鈴錢賣出 20 顆大頭菜。

FacadePatternTest.php
```php
/**
 * Class FacadePatternTest.
 */
class FacadePatternTest extends TestCase
{
    /**
     * @test
     */
    public function test_buy_and_sell_turnips()
    {
        $bag = new Bag();
        $store = new Store();
        $daisyMae = new DaisyMae();
        $facade = new Facade($bag, $store, $daisyMae);

        // 在背包裡塞入 10,000 鈴錢
        $this->assertEquals(10000, $facade->takeupBells(10000));

        // 購買 40 顆單價 100 鈴錢的大頭菜
        $this->assertEquals(6000 ,$facade->buyTurnips(100, 40));

        // 以 400 鈴錢賣出 20 顆大頭菜
        $this->assertEquals(14000 ,$facade->sellTurnips(400, 20));

        // 從背包拿出 10,000 鈴錢
        $this->assertEquals(4000 ,$facade->takeoutBells(10000));

        // 再以 600 鈴錢賣出 20 顆大頭菜
        $this->assertEquals(16000 ,$facade->sellTurnips(600, 20));
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

Time: 00:00.028, Memory: 6.00 MB

OK (42 tests, 93 assertions)
```

## 完整程式碼
[設計模式不難，找回快樂而已，以大頭菜為例。](https://github.com/Kantai235/php-design-pattern)
- [技術部落格文章 - 外觀模式](https://kantai235.github.io/FacadePattern)
- [外觀模式 原始碼](https://github.com/Kantai235/php-design-pattern/master/DesignPatterns/Structural/FacadePattern)
- [外觀模式 測試](https://github.com/Kantai235/php-design-pattern/master/Tests/Structural/FacadePatternTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

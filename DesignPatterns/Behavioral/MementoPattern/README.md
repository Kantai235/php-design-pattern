![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/MementoPattern/Banner.png)

# 備忘錄模式 Memento Pattern
備忘錄模式，在不破壞封裝物件的前提之下，提供物件一個「皇后殺手 第三爆彈：敗者成塵」的能力，物件在極度絕望的狀態下，把當前物件炸光光，並令時間往前倒退至上一個時空紀錄點的設計模式，跟吉良吉影的不同點在於命運會跟著被改變，被破壞的東西會恢復原狀。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/MementoPattern/UML.png)

## 實作
為了讓大頭菜有爆掉並往前倒退至上一個時空紀錄點的功能，這次我們要先實作備忘錄模式，用來儲存大頭菜的時空狀態，好讓大頭菜可以回到過去。

大頭菜：「キラークイーン、バイツ・ザ・ダスト！」

Memento.php
```php
/**
 * Class Memento.
 */
class Memento
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
     * Memento constructor.
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

接下來要實作擁有第三爆彈的大頭菜，除了以往所擁有的資訊、方法以外，這次要提供儲存、載入的功能，讓大頭菜能在任意的時空點進行儲存，並且在自己被逼到極限時，按下第三爆彈穿越時空回到過去。

大頭菜：「到極限了，就是現在，按下去！」

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
     * @return Memento
     */
    public function saveToMemento(): Memento
    {
        return new Memento($this->price, $this->count);
    }

    /**
     * @param Memento $memento
     */
    public function restoreFromMemento(Memento $memento)
    {
        $this->price = $memento->getPrice();
        $this->count = $memento->getCount();
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
    public function calculatePrice(): int
    {
        return $this->getPrice() * $this->getCount();
    }
}
```

## 測試
接下來我們要替第三爆彈模式測試一下，要讓大頭菜真的儲存某個時空點，並且按下爆彈炸毀當前物件，然後飛躍時空回到過去。

MementoPatternTest.php
```php
/**
 * Class MementoPatternTest.
 */
class MementoPatternTest extends TestCase
{
    /**
     * @test
     */
    public function test_bites_the_dust()
    {
        $turnips = new Turnips(100, 40);
        $this->assertEquals(4000, $turnips->calculatePrice());

        /**
         * 儲存當前時空
         */
        $memento = $turnips->saveToMemento();

        $newPrice = random_int(0, 600);
        $turnips->setPrice($newPrice);
        $this->assertEquals($newPrice * 40, $turnips->calculatePrice());

        /**
         * 到極限了，就是現在，按下去！
         */
        $turnips->restoreFromMemento($memento);
        $this->assertEquals(4000, $turnips->calculatePrice());
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

Time: 00:00.105, Memory: 6.00 MB

OK (63 tests, 132 assertions)
```

## 完整程式碼
[設計模式不難，找回快樂而已，以大頭菜為例。](https://github.com/Kantai235/php-design-pattern)
- [技術部落格文章 - 備忘錄模式](https://kantai235.github.io/MementoPattern)
- [備忘錄模式 原始碼](https://github.com/Kantai235/php-design-pattern/tree/master/DesignPatterns/Behavioral/MementoPattern)
- [備忘錄模式 測試](https://github.com/Kantai235/php-design-pattern/tree/master/Tests/Behavioral/MementoPatternTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

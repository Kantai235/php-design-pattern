![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Creational/PoolPattern/Banner.png)

# 物件池模式 Pool Pattern
物件池模式，每次的買賣都是致富的關鍵，致富不能只靠 40 顆大頭菜，靠的是放滿整座島的大頭菜，因此你需要有個島專門放大頭菜，放得滿滿的，到了關鍵時刻再把大頭菜拿出來賣。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Creational/PoolPattern/UML.png)

## 實作
首先我們會需要把大頭菜定義出來，並且賦予幾些簡單的功能。

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

再來我們要做一個大頭菜池，而且要挖深，挖深呢，好處是有利於儲大頭菜，未來還可以養大頭菜，然後就可以把大頭菜通通丟進去。

TurnipsPool.php
```php
use Countable;

/**
 * Class TurnipsPool.
 */
class TurnipsPool implements Countable
{
    /**
     * @var Turnips[]
     */
    protected $pool = [];

    /**
     * @var int
     */
    protected $total = 0;

    /**
     * @return Turnips
     */
    public function get(string $key = null): Turnips
    {
        if (isset($key)) {
            $turnips = $this->pool[$key];
            unset($this->pool[$key]);
        } else {
            $turnips = array_pop($this->pool);
        }

        $this->total -= $turnips->calculatePrice();

        return $turnips;
    }

    /**
     * 把大頭菜塞到池子裡
     *
     * @param Turnips $turnips
     * 
     * @return string
     */
    public function set(Turnips $turnips): string
    {
        $key = spl_object_hash($turnips);
        $this->total += $turnips->calculatePrice();
        $this->pool[$key] = $turnips;

        return $key;
    }

    /**
     * @return int
     */
    public function total(): int
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->pool);
    }
}
```

## 測試
最後為了測試我們挖很深的大頭菜池是否能夠養大頭菜，所以我們有兩組測試要做：
1. 測試是否能夠正常的新增 10 組大頭菜，並且把大頭菜拿出 2 組後，檢查池子裡面是否剩下 8 組大頭菜，然後比較一下拿出來的這 2 組是不是兩個不同的大頭菜，最後比較一下大頭菜池子裡的大頭菜價格是不是正確的。
2. 測試是否能夠正常的新增 10 組大頭菜，並且把大頭菜拿出 1 組後，馬上把大頭菜丟回去池子裡，再從池子裡拿出 1 組大頭菜，檢查池子裡面是否剩下 9 組大頭菜，然後比較一下最後拿出來的這組，是不是就是一開始拿出來的那組大頭菜，最後比較一下大頭菜池子裡的大頭菜價格是不是正確的。

PoolPatternTest.php
```php
/**
 * Class PoolPatternTest.
 */
class PoolPatternTest extends TestCase
{
    /**
     * 測試是否能夠正常的新增 10 組大頭菜，
     * 並且把大頭菜拿出 2 組後，檢查池子裡面是否剩下 8 組大頭菜，
     * 然後比較一下拿出來的這 2 組是不是兩個不同的大頭菜，
     * 最後比較一下大頭菜池子裡的大頭菜價格是不是正確的。
     * 
     * @test
     */
    public function test_can_set_new_turnips_and_get()
    {
        $pool = new TurnipsPool();
        for ($i = 0; $i < 10; $i++) {
            $turnips = new Turnips(100, 40);
            $pool->set($turnips);
        }

        $turnips1 = $pool->get();
        $turnips2 = $pool->get();

        $this->assertCount(8, $pool);
        $this->assertNotSame($turnips1, $turnips2);
        $this->assertEquals(32000, $pool->total());
    }

    /** 
     * 測試是否能夠正常的新增 10 組大頭菜，
     * 並且把大頭菜拿出 1 組後，馬上把大頭菜丟回去池子裡，
     * 再從池子裡拿出 1 組大頭菜，
     * 檢查池子裡面是否剩下 9 組大頭菜，
     * 然後比較一下最後拿出來的這組，是不是就是一開始拿出來的那組大頭菜，
     * 最後比較一下大頭菜池子裡的大頭菜價格是不是正確的。
     * 
     * @test
     */
    public function test_can_get_turnips_twice_when_set_it_first()
    {
        $pool = new TurnipsPool();
        for ($i = 0; $i < 10; $i++) {
            $turnips = new Turnips(100, 40);
            $pool->set($turnips);
        }

        $turnips1 = $pool->get();
        $pool->set($turnips1);

        $turnips2 = $pool->get();

        $this->assertCount(9, $pool);
        $this->assertSame($turnips1, $turnips2);
        $this->assertEquals(36000, $pool->total());
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
- [技術部落格文章 - 物件池模式](https://kantai235.github.io/PoolPattern)
- [物件池模式 原始碼](https://github.com/Kantai235/php-design-pattern/master/DesignPatterns/Creational/PoolPattern)
- [物件池模式 測試](https://github.com/Kantai235/php-design-pattern/master/Tests/Creational/PoolPatternTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

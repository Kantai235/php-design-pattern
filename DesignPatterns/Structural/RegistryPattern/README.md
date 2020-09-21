![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Structural/RegistryPattern/Banner.png)

# 註冊模式 Registry Pattern
註冊模式，如果應用程式內有非常多同樣的物件需要高度重複讀寫，就會去建立一個儲存器來負責管理這些同樣的物件，就有點像是你的大頭菜，會來自不同的島，每座的島菜價不同，這會導致你很難算出所賺到的鈴錢，所以如果每個大頭菜都需要登記註冊，然後有個集中管理的名冊，在管理大頭菜這件事上就能比較輕鬆。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Structural/RegistryPattern/UML.png)

## 實作
首先我們會先建立需要被集中管理的大頭菜物件，裡面提供了簡單的幾些方法，例如賦予獲得島嶼名稱、鈴錢以及數量。

```php
/**
 * Class Turnips.
 */
class Turnips
{
    /**
     * @var string
     */
    public string $island;

    /**
     * @var int
     */
    public int $price;

    /**
     * @var int
     */
    public int $count;

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
}
```

再來我們需要建立一個集中管理大頭菜的抽象註冊器，無論是找尋(find...)註冊、更新或刪除，這些事情都會集中在這裡實踐。

```php
use InvalidArgumentException;

/**
 * Abstract Registry.
 */
abstract class Registry
{
    /**
     * @var Turnips[]
     */
    protected static array $turnips = [];

    /**
     * @param
     * 
     * @throws InvalidArgumentException
     * @return Turnips|null
     */
    public static function findTurnipsByIsland(string $island)
    {
        foreach (self::$turnips as $turnip) {
            if ($island === $turnip->getIsland()) {
                return $turnip;
            }
        }

        throw new InvalidArgumentException('大頭菜儲存容器找不到目標。');
    }

    /**
     * @param
     * 
     * @return Turnips|null
     */
    public static function findIndexByIsland(string $island)
    {
        foreach (self::$turnips as $index => $turnip) {
            if ($island === $turnip->getIsland()) {
                return $index;
            }
        }

        return null;
    }

    /**
     * @param string  $island
     * @param Turnips $turnip
     * 
     * @throws InvalidArgumentException
     */
    public static function store(Turnips $turnip)
    {
        if (self::findIndexByIsland($turnip->getIsland())) {
            throw new InvalidArgumentException('大頭菜儲存容器已經包含這顆大頭菜了。');
        }

        array_push(self::$turnips, $turnip);
    }

    /**
     * @param Turnips $turnip
     * 
     * @throws InvalidArgumentException
     */
    public static function update(Turnips $turnips)
    {
        if ($index = self::findIndexByIsland($turnips->getIsland())) {
            self::$turnips[$index]->setPrice($turnips->getPrice());
            self::$turnips[$index]->setCount($turnips->getCount());

            return;
        }

        throw new InvalidArgumentException('大頭菜儲存容器找不到目標。');
    }

    /**
     * @param string  $island
     * @param Turnips $turnip
     * 
     * @throws InvalidArgumentException
     */
    public static function destroy(Turnips $turnips)
    {
        if ($index = self::findIndexByIsland($turnips->getIsland())) {
            unset(self::$turnips[$index]);
            
            return;
        }

        throw new InvalidArgumentException('大頭菜儲存容器找不到目標。');
    }
}
```

## 測試
註冊器寫完以後，雖然程式很簡短，但需要做的測試有不少，會有幾個需要做的測試項目：
1. 測試是否能夠建立大頭菜，放入後並取出是稍早建立的大頭菜。
2. 測試連續建立重複的大頭菜是否會獲得錯誤。
3. 測試直接獲取不存在的大頭菜索引是否會獲得空值。
4. 測試建立大頭菜並更新大頭菜之後，大頭菜資訊是否有正確更新。
5. 測試大頭菜是否能夠被移除。

```php
use InvalidArgumentException;

/**
 * Class RegistryPatternTest.
 */
class RegistryPatternTest extends TestCase
{
    /**
     * 測試是否能夠建立大頭菜，放入後並取出是稍早建立的大頭菜。
     * 
     * @test
     */
    public function test_registry_store()
    {
        $turnips = new Turnips('Island_A', 100, 40);
        Registry::store($turnips);

        $this->assertSame($turnips, Registry::findTurnipsByIsland('Island_A'));
    }

    /**
     * 測試連續建立重複的大頭菜是否會獲得錯誤。
     * 
     * @test
     */
    public function test_registry_store_exception()
    {
        $this->expectException(InvalidArgumentException::class);

        $turnips = new Turnips('Island_B', 100, 40);
        Registry::store($turnips);
        Registry::store($turnips);
    }

    /**
     * 測試直接獲取不存在的大頭菜索引是否會獲得空值。
     * 
     * @test
     */
    public function test_registry_get_exception()
    {
        $this->assertNull(Registry::findIndexByIsland('Island_Null'));
    }

    /**
     * 測試建立大頭菜並更新大頭菜之後，大頭菜資訊是否有正確更新。
     * 
     * @test
     */
    public function test_registry_update()
    {
        $turnips = new Turnips('Island_C', 100, 40);
        Registry::store($turnips);

        $turnips->setPrice(90);
        $turnips->setCount(20);
        Registry::update($turnips);

        $this->assertSame($turnips, Registry::findTurnipsByIsland('Island_C'));
    }

    /**
     * 測試大頭菜是否能夠被移除。
     * 
     * @test
     */
    public function test_registry_destroy()
    {
        $turnips = new Turnips('Island_D', 100, 40);
        Registry::store($turnips);
        $this->assertSame($turnips, Registry::findTurnipsByIsland('Island_D'));

        $this->expectException(InvalidArgumentException::class);
        Registry::destroy($turnips);
        Registry::findTurnipsByIsland('Island_D');
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
 ==> RegistryPatternTest        ✔  ✔  ✔  ✔  ✔  

Time: 00:00.037, Memory: 6.00 MB

OK (51 tests, 116 assertions)
```

## 完整程式碼
[設計模式不難，找回快樂而已，以大頭菜為例。](https://github.com/Kantai235/php-design-pattern)
- [技術部落格文章 - 註冊模式](https://kantai235.github.io/RegistryPattern)
- [註冊模式 原始碼](https://github.com/Kantai235/php-design-pattern/master/DesignPatterns/Structural/RegistryPattern)
- [註冊模式 測試](https://github.com/Kantai235/php-design-pattern/master/Tests/Structural/RegistryPatternTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

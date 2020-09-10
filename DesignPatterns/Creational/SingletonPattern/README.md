![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Creational/SingletonPattern/Banner.png)

# 單例模式 Singleton Pattern
單例模式，整個應用程式只會有一個實體，這個實體不會重複建立，就有點像是整座島上只有一個曹賣，這個曹賣在你這座島的時間，你可以盡量找他買大頭菜，無論你做什麼事情，大頭菜在這段時間內都不會任意更動，你的曹賣是你的曹賣，不會因為你進去博物館逛一圈再出來而改變。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Creational/SingletonPattern/UML.png)

## 實作
我們需要建立一個大頭菜類別，裡面放著一顆大頭菜。

Turnips.php
```php
/**
 * Class Turnips.
 */
final class Turnips
{
    /**
     * @var Turnips
     */
    protected static $turnips;
}
```

再來我們需要有個方法來獲得這顆大頭菜，並且這顆大頭菜只要被建立過，無論怎麼建立大頭菜，所獲得的物件永遠會是第一顆大頭菜。

Turnips.php
```php
    /**
     * 透過延遲載入的方式來取得大頭菜
     * 
     * @return Turnips
     */
    public static function getTurnips(): Turnips
    {
        if (static::$turnips === null) {
            static::$turnips = new static();
        }

        return static::$turnips;
    }
```

最後為了防止大頭菜被用各種意想不到的 BUG 來建立，所以要設下種種防線。

Turnips.php
```php
    /**
     * 不允許自己生產大頭菜，你必須去跟曹賣買
     * 為了防止玩家自己生產大頭菜，必須透過 Turnips::getTurnips() 方法來取得大頭菜
     */
    private function __construct()
    {
        // ...
    }

    /**
     * 防止大頭菜被玩家複製
     */
    private function __clone()
    {
        // ...
    }

    /**
     * 防止大頭菜被反序列化，這個過程會建立大頭菜的副本
     */
    private function __wakeup()
    {
        // ...
    }
```

## 測試
最後為了驗證我們前面所撰寫的大頭菜是否正確，我們需要寫個測試，測試建立兩個大頭菜，並且獲取大頭菜物件，比對一下兩個是不是都是大頭菜，以及兩個是不是一樣的大頭菜。

SingletonPatternTest.php
```php
use PHPUnit\Framework\TestCase;

/**
 * Class SingletonPatternTest.
 */
class SingletonPatternTest extends TestCase
{
    /**
     * 建立兩個大頭菜，比較兩個是否都是大頭菜，而且兩個大頭菜都是一模一樣的東西。
     * 
     * @test
     */
    public function test_uniqueness()
    {
        $turnipsA = Turnips::getTurnips();
        $turnipsB = Turnips::getTurnips();

        $this->assertInstanceOf(Turnips::class, $turnipsA);
        $this->assertInstanceOf(Turnips::class, $turnipsB);
        $this->assertSame($turnipsA, $turnipsB);
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
- [技術部落格文章 - 單例模式](https://kantai235.github.io/SingletonPattern)
- [單例模式 原始碼](https://github.com/Kantai235/php-design-pattern/master/DesignPatterns/Creational/SingletonPattern)
- [單例模式 測試](https://github.com/Kantai235/php-design-pattern/master/Tests/Creational/SingletonPatternTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

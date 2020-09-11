![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/CommandPattern/Banner.png)

# 命令模式 Command Pattern
命令模式，是一種將行為封裝起來裹上美好糖衣的一種模式，並將接收與執行分離出來，就有點像是把大頭菜買賣這件事，如果把買大頭菜、賣大頭菜這兩個動作封裝起來，變成一個命令，分開去執行。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/CommandPattern/UML.png)

## 實作
首先我們要先定義命令介面(Command)，這個介面需要實作執行(execute)這個方法。

Command.php
```php
/**
 * Interface Command.
 */
interface Command
{
    /**
     * @return void
     */
    public function execute();
}
```

再來我們需要建立命令的執行者(Invoker)、接收者(Receiver)，首先執行者會擁有執行命令(Command)的行為，而接收者則是會有特定的功能，像是買入大頭菜、販售大頭菜。

Invoker.php
```php
/**
 * Class Invoker.
 */
class Invoker
{
    /**
     * @var Command
     */
    protected Command $command;

    /**
     * @param Command $command
     */
    public function setCommand(Command $command)
    {
        $this->command = $command;
    }

    /**
     * @return void
     */
    public function run()
    {
        $this->command->execute();
    }
}
```

Receiver.php
```php
/**
 * Class Receiver.
 */
class Receiver
{
    /**
     * @var int
     */
    protected int $turnips = 0;

    /**
     * @var int
     */
    protected int $bells = 0;

    /**
     * @param int $price
     * @param int $count
     */
    public function buy(int $price, int $count)
    {
        $total = $price * $count;
        if ($this->bells < $total) {
            throw new \InvalidArgumentException('您的鈴錢不足，無法購買大頭菜。');
        }

        $this->turnips += $count;
        $this->bells -= $total;
    }

    /**
     * @param int $price
     * @param int $count
     */
    public function sell(int $price, int $count)
    {
        if ($this->turnips < $count) {
            throw new \InvalidArgumentException('您的大頭菜不足，無法販賣大頭菜。');
        }

        $total = $price * $count;
        $this->turnips -= $count;
        $this->bells += $total;
    }

    /**
     * @param int $bells
     */
    public function setBells(int $bells)
    {
        $this->bells += $bells;
    }

    /**
     * @return int
     */
    public function getBells(): int
    {
        return $this->bells;
    }
}
```

Receiver.php
```php
/**
 * Class Receiver.
 */
class Receiver
{
    /**
     * @var int
     */
    protected int $turnips = 0;

    /**
     * @var int
     */
    protected int $bells = 0;

    /**
     * @param int $price
     * @param int $count
     */
    public function buy(int $price, int $count)
    {
        $total = $price * $count;
        if ($this->bells < $total) {
            throw new \InvalidArgumentException('您的鈴錢不足，無法購買大頭菜。');
        }

        $this->turnips += $count;
        $this->bells -= $total;
    }

    /**
     * @param int $price
     * @param int $count
     */
    public function sell(int $price, int $count)
    {
        if ($this->turnips < $count) {
            throw new \InvalidArgumentException('您的大頭菜不足，無法販賣大頭菜。');
        }

        $total = $price * $count;
        $this->turnips -= $count;
        $this->bells += $total;
    }

    /**
     * @param int $bells
     */
    public function setBells(int $bells)
    {
        $this->bells += $bells;
    }

    /**
     * @return int
     */
    public function getBells(): int
    {
        return $this->bells;
    }
}
```

最後要來建立購買(Buy)以及販賣(Sell)的命令(Command)，這邊會直接去執行命令所需要做的事情。

BuyCommand.php
```php
/**
 * Class BuyCommand.
 */
class BuyCommand implements Command
{
    /**
     * @var Receiver
     */
    protected Receiver $console;

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
     * @param Receiver $console
     */
    public function __construct(Receiver $console, int $price, int $count)
    {
        $this->console = $console;
        $this->price = $price;
        $this->count = $count;
    }

    /**
     * @return void
     */
    public function execute()
    {
        $this->console->buy($this->price, $this->count);
    }
}
```

SellCommand.php
```php
/**
 * Class SellCommand.
 */
class SellCommand implements Command
{
    /**
     * @var Receiver
     */
    protected Receiver $console;

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
     * @param Receiver $console
     */
    public function __construct(Receiver $console, int $price, int $count)
    {
        $this->console = $console;
        $this->price = $price;
        $this->count = $count;
    }

    /**
     * @return void
     */
    public function execute()
    {
        $this->console->sell($this->price, $this->count);
    }
}
```

## 測試
最後要對大頭菜命令模式測試一下，主要會先建立執行與接收，然後先放個 10,000 鈴錢，才有鈴錢買大頭菜，接下來執行一些命令(Command)測試：
1. 購買大頭菜的命令(BuyCommand)。
2. 販賣大頭菜的命令(SellCommand)。

CommandPatternTest.php
```php
/**
 * Class CommandPatternTest.
 */
class CommandPatternTest extends TestCase
{
    /**
     * @test
     */
    public function test_invocation()
    {
        $invoker = new Invoker();
        $receiver = new Receiver();
        $receiver->setBells(10000);

        $invoker->setCommand(new BuyCommand($receiver, 100, 40));
        $invoker->run();
        $this->assertSame(6000, $receiver->getBells());

        $invoker->setCommand(new SellCommand($receiver, 200, 40));
        $invoker->run();
        $this->assertSame(14000, $receiver->getBells());
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

Time: 00:00.062, Memory: 6.00 MB

OK (55 tests, 122 assertions)
```

## 完整程式碼
[設計模式不難，找回快樂而已，以大頭菜為例。](https://github.com/Kantai235/php-design-pattern)
- [技術部落格文章 - 命令模式](https://kantai235.github.io/CommandPattern)
- [命令模式 原始碼](https://github.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/CommandPattern)
- [命令模式 測試](https://github.com/Kantai235/php-design-pattern/master/Tests/Behavioral/CommandPatternTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

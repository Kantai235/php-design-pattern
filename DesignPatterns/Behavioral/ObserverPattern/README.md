![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/ObserverPattern/Banner.png)

# 觀察者模式 Observer Pattern
觀察者模式，一種現在全中國都知道你來了的模式，就有點像是收音機，打開收音機就開始自動接收廣播，關掉收音機就停止接收，就有點像是動森的連線模式，你跟朋友在同一座島遊玩時，如果有其他朋友來玩，那你們通通都會收到這個通知，然後開始看渡渡鳥航空飛起來的動畫。

![現在全中國都知道你來了](https://memes.tw/user-template/7a3ef7817e20b4329ca542fb154db593.png)

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/ObserverPattern/UML.png)

## 實作
這次我們要實作有一座島嶼(Island)讓玩家(Player)加入，當有玩家加入島嶼時，島嶼上其他的玩家會收到系統通知，所以會需要讓島嶼(Island)去繼承 `SplSubject` 這個類別，讓島嶼可以把玩家加入島嶼當中、讓玩家離開島嶼，實作這些時也順便通知其他玩家事件的產生，最後提供一個 `sendMessages` 的方法來通知當前所有加入觀察者名單的玩家。

Island.php
```php
/**
 * Class Island.
 */
class Island implements SplSubject
{
    /**
     * 用來存放觀察者名單。
     * 
     * @var SplObjectStorage
     */
    protected SplObjectStorage $observers;

    /**
     * Island constructor.
     */
    public function __construct()
    {
        $this->observers = new SplObjectStorage();
    }

    /**
     * 賦予觀察者物件。
     * 
     * @param SplObserver $observer
     */
    public function attach(SplObserver $observer)
    {
        $this->sendMessages("有玩家加入了！");
        $this->observers->attach($observer);
    }

    /**
     * 抽離觀察者物件。
     * 
     * @param SplObserver $observer
     */
    public function detach(SplObserver $observer)
    {
        $this->observers->detach($observer);
        $this->sendMessages("有玩家離開了！");
    }

    /**
     * 通知觀察者。
     */
    public function notify()
    {
        foreach ($this->observers as $observer) {
            $observer->update();
        }
    }

    /**
     * 發佈訊息給所有的觀察者。
     * 
     * @param string $message
     */
    public function sendMessages(string $message)
    {
        foreach ($this->observers as $observer) {
            $observer->sendMessage($message);
        }
    }
}
```

實作完島嶼以後，接下來要把玩家(Player)建立出來，讓玩家去繼承 `SplObserver` 這個類別，這些類別是 `php` 內建提供觀察者模式的類別，詳細資訊列在 #額外補充 當中，另外需要額外提供一個 `sendMessage` 方法，代表玩家收到島嶼發出來的通知了，所以把訊息輸出出來，並補上玩家名稱的標示。

```php
/**
 * Class PlayerObserver.
 */
class PlayerObserver implements SplObserver
{
    /**
     * @var string
     */
    protected string $user;

    /**
     * @var SplSubject[]
     */
    protected array $observers = [];
    
    /**
     * PlayerObserver constructor.
     * 
     * @param string $user
     */
    public function __construct(string $user)
    {
        $this->user = $user;
    }

    /**
     * @param SplSubject $subject
     */
    public function update(SplSubject $subject)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param string $message
     */
    public function sendMessage(string $message)
    {
        echo "[$this->user 收到通知] $message";
    }
}
```

## 額外補充
### SplSubject
繼承 `SplSubject` 這個類別會需要實作 `attach`、`detach` 及 `notify` 這三個方法，`attach` 會需要賦予 `SplObserver` 觀察者物件，也就是把觀察者加入集合當中，而 `detach` 則是抽離指定的 `SplObserver` 物件，也就是把觀察者拔除，最後 `notify` 則是通知仍然存在於集合中的觀察者們。
```php
SplSubject {
    /* Methods */
    abstract public attach ( SplObserver $observer ) : void
    abstract public detach ( SplObserver $observer ) : void
    abstract public notify ( void ) : void
}
```
- 官方文件：[PHP: SplSubject - Manual](https://www.php.net/manual/en/class.splsubject.php)

### SplObserver
繼承 `SplObserver` 這個類別會需要實作 `update` 這個方法。
```php
SplObserver {
    /* Methods */
    abstract public update ( SplSubject $subject ) : void
}
```
- 官方文件：[PHP: SplObserver - Manual](https://www.php.net/manual/en/class.splobserver.php)

### SplObjectStorage
`SplObjectStorage` 這個類別則是提供一系列的方法供使用。
```php
SplObjectStorage implements Countable , Iterator , Serializable , ArrayAccess {
    /* Methods */
    public addAll ( SplObjectStorage $storage ) : void
    public attach ( object $object [, mixed $data = NULL ] ) : void
    public contains ( object $object ) : bool
    public count ( void ) : int
    public current ( void ) : object
    public detach ( object $object ) : void
    public getHash ( object $object ) : string
    public getInfo ( void ) : mixed
    public key ( void ) : int
    public next ( void ) : void
    public offsetExists ( object $object ) : bool
    public offsetGet ( object $object ) : mixed
    public offsetSet ( object $object [, mixed $data = NULL ] ) : void
    public offsetUnset ( object $object ) : void
    public removeAll ( SplObjectStorage $storage ) : void
    public removeAllExcept ( SplObjectStorage $storage ) : void
    public rewind ( void ) : void
    public serialize ( void ) : string
    public setInfo ( mixed $data ) : void
    public unserialize ( string $serialized ) : void
    public valid ( void ) : bool
}
```
- 官方文件：[PHP: SplObjectStorage - Manual](https://www.php.net/manual/en/class.splobjectstorage.php)

## 測試
這次的測試會假設有一座島嶼建立起來，並且陸續有玩家加入、離開，模擬這段過程所會產生的訊息是否正確，所以會預設幾些動作、動作所產生的訊息：
1. 建立島嶼(Island)
2. 建立玩家(Player A)，加入前島嶼上還沒有玩家，所以沒有人收到通知。
3. 建立玩家(Player B)，加入前島嶼上已經有玩家 A 了，所以會產生以下通知：
    1. [Player A 收到通知] 有玩家加入了！
4. 建立玩家(Player C)，加入前島嶼上已經有玩家 A、B 了，所以會產生以下通知：
    1. [Player A 收到通知] 有玩家加入了！
    2. [Player B 收到通知] 有玩家加入了！
5. 玩家(Player B)離開了島嶼，離開後島嶼上剩下 A、C 玩家，所以會產生以下通知：
    1. [Player A 收到通知] 有玩家離開了！
    2. [Player C 收到通知] 有玩家離開了！

```php
/**
 * Class ObserverPatternTest.
 */
class ObserverPatternTest extends TestCase
{
    /**
     * @test
     */
    public function test_observer()
    {
        $this->expectOutputString(implode(array(
            "[Player A 收到通知] 有玩家加入了！",
            "[Player A 收到通知] 有玩家加入了！",
            "[Player B 收到通知] 有玩家加入了！",
            "[Player A 收到通知] 有玩家離開了！",
            "[Player C 收到通知] 有玩家離開了！",
        )));
        
        /**
         * 建立一個島嶼
         */
        $island = new Island();

        /**
         * Player A 加入了這座島嶼
         * 加入前島上沒有玩家
         * 所以沒有叮咚通知
         */
        $playerA = new PlayerObserver('Player A');
        $island->attach($playerA);

        /**
         * Player B 加入了這座島嶼
         * 加入前島上有 1 位玩家
         * 扣除自己後，會有 A 收到叮咚通知
         */
        $playerB = new PlayerObserver('Player B');
        $island->attach($playerB);

        /**
         * Player C 加入了這座島嶼
         * 加入前島上有 2 位玩家
         * 扣除自己後，會有 A、B 收到叮咚通知
         */
        $playerC = new PlayerObserver('Player C');
        $island->attach($playerC);

        /**
         * Island_B 離開了這座島嶼
         * 離開前島上有 3 位玩家
         * 扣除自己後，會有 A、C 收到叮咚通知
         */
        $island->detach($playerB);
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

Time: 00:00.097, Memory: 8.00 MB

OK (68 tests, 137 assertions)
```

## 完整程式碼
[設計模式不難，找回快樂而已，以大頭菜為例。](https://github.com/Kantai235/php-design-pattern)
- [技術部落格文章 - 觀察者模式](https://kantai235.github.io/ObserverPattern)
- [觀察者模式 原始碼](https://github.com/Kantai235/php-design-pattern/tree/master/DesignPatterns/Behavioral/ObserverPattern)
- [觀察者模式 測試](https://github.com/Kantai235/php-design-pattern/tree/master/Tests/Behavioral/ObserverPatternTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/ObserverPattern/Banner.png)

# 觀察者模式 Observer Pattern
觀察者模式，一種現在全中國都知道你來了的模式，就有點像是收音機，打開收音機就開始自動接收廣播，關掉收音機就停止接收，就有點像是動森的連線模式，你跟朋友在同一座島遊玩時，如果有其他朋友來玩，那你們通通都會收到這個通知，然後開始看渡渡鳥航空飛起來的動畫。

![現在全中國都知道你來了](https://memes.tw/user-template/7a3ef7817e20b4329ca542fb154db593.png)

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Behavioral/ObserverPattern/UML.png)

## 實作

## 額外補充
### SplSubject
繼承 `SplSubject` 這個類別會需要實作 `attach`、`detach` 及 `notify` 這三個方法，`attach` 會需要賦予 `SplObserver` 觀察者物件，而 `detach` 則是抽離 `` 
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
繼承 `SplObserver` 這個類別 bla bla bla ...
```php
SplObserver {
    /* Methods */
    abstract public update ( SplSubject $subject ) : void
}
```
- 官方文件：[PHP: SplObserver - Manual](https://www.php.net/manual/en/class.splobserver.php)

### SplObjectStorage
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
- [技術部落格文章 - 觀察者模式](https://kantai235.github.io/ObserverPattern)
- [觀察者模式 原始碼](https://github.com/Kantai235/php-design-pattern/tree/master/DesignPatterns/Behavioral/ObserverPattern)
- [觀察者模式 測試](https://github.com/Kantai235/php-design-pattern/tree/master/Tests/Behavioral/ObserverPatternTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

![Banner](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Structural/DataMapper/Banner.png)

# 資料對應 Data Mapper
資料對應，這是一種常用於處理物件導向與資料庫資料的模式，與 `Repository` 不同，`Data Mapper` 主要處理的事單個物件本身，而 `Repository` 處理的是物件的集合。這次實作舉個例子，你在買大頭菜之前，需要有一個草圖去評估你要前往哪些島上買大頭菜，決定好之後再開始行動。

## UML
![UML](https://raw.githubusercontent.com/Kantai235/php-design-pattern/master/DesignPatterns/Structural/DataMapper/UML.png)

## 實作
首先我們要先把大頭菜給實作出來，這次因為大頭菜可以來自不同的島嶼，因此多了島嶼名稱，以及透過 `new self(...)` 的方式來回傳新的大頭菜物件。

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
    protected $island;

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
     * @param string $island
     * @param int    $price
     * @param int    $count
     */
    public function __construct(string $island, int $price, int $count)
    {
        $this->island = $island;
        $this->price = $price;
        $this->count = $count;
    }

    /**
     * @param array $island
     * 
     * @return Turnips
     */
    public static function fromIsland(array $island): Turnips
    {
        return new self(
            $island['island'],
            $island['price'],
            $island['count']
        );
    }
}
```

`Turnips` 你可以理解為 ORM 物件，所以接下來要製作所謂的草稿(StorageAdapter)以及對應的中間層(TurnipsMapper)，把草稿寫好之後，丟進去中間層(TurnipsMapper)就可以對應到每個大頭菜物件。

> 【補充說明】
> 物件關聯對映（英語：Object Relational Mapping，簡稱ORM，或O/RM，或O/R mapping），是一種程式設計技術，用於實現物件導向程式語言裡不同類型系統的資料之間的轉換。從效果上說，它其實是建立了一個可在程式語言裡使用的「虛擬物件資料庫」。如今已有很多免費和付費的ORM產品，而有些程式設計師更傾向於建立自己的ORM工具。
> 資料來源：[維基百科](https://zh.wikipedia.org/wiki/对象关系映射)

TurnipsMapper.php
```php
use InvalidArgumentException;

/**
 * Class TurnipsMapper.
 */
class TurnipsMapper
{
    /**
     * @var StorageAdapter
     */
    protected $adapter;

    /**
     * TurnipsMapper constructor.
     *
     * @param StorageAdapter $storage
     */
    public function __construct(StorageAdapter $storage)
    {
        $this->adapter = $storage;
    }

    /**
     * @param int $id
     *
     * @throws InvalidArgumentException
     * @return Turnips
     */
    public function findById(int $id): Turnips
    {
        $result = $this->adapter->findById($id);

        if ($result === null) {
            throw new InvalidArgumentException("找不到 ID 為「 $id 」的島嶼。");
        }

        return $this->mapRowToTurnips($result);
    }

    /**
     * @param int $id
     *
     * @throws InvalidArgumentException
     * @return Turnips
     */
    public function findByIsland(string $island): Turnips
    {
        $result = $this->adapter->findByIsland($island);

        if ($result === null) {
            throw new InvalidArgumentException("找不到名稱為「 $island 」的島嶼。");
        }

        return $this->mapRowToTurnips($result);
    }

    /**
     * @param array $row
     * 
     * @return Turnips
     */
    protected function mapRowToTurnips(array $row): Turnips
    {
        return Turnips::fromIsland($row);
    }
}
```

StorageAdapter.php
```php
/**
 * Class StorageAdapter.
 */
class StorageAdapter
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * StorageAdapter constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param int $id
     *
     * @return array|null
     */
    public function findById(int $id)
    {
        if (isset($this->data[$id])) {
            return $this->data[$id];
        }

        return null;
    }

    /**
     * @param string $island
     *
     * @return array|null
     */
    public function findByIsland(string $island)
    {
        $key = array_search($island, array_column($this->data, 'island'));
        if (false !== $key) {
            return $this->data[$key];
        }
        
        return null;
    }
}
```

## 測試
撰寫完資料對應器之後，接下來要寫些測試來驗證資料對應器是否能夠正確的運作，預期是繪製好草圖，把草圖塞入對應器之後，獲得相對應的大頭菜物件，所以會有以下幾個重點項目需要測試：
1. 測試塞入大頭菜列，並且取得 id 為 1 的大頭菜。
2. 測試塞入空的大頭菜列，並且成功獲得例外錯誤。

```php
/**
 * Class DataMapperTest.
 */
class DataMapperTest extends TestCase
{
    /**
     * 測試塞入大頭菜列，並且取得 id 為 1 的大頭菜。
     * 
     * @test
     */
    public function test_can_map_turnips_from_storage()
    {
        $storage = new StorageAdapter(
            array(
                1 => array(
                    'island' => 'kantai',
                    'price' => 100,
                    'count' => 40,
                ),
            ),
        );

        $mapper = new TurnipsMapper($storage);

        $turnips = $mapper->findById(1);

        $this->assertInstanceOf(Turnips::class, $turnips);
    }

    /**
     * 測試塞入空的大頭菜列，並且成功獲得例外錯誤。
     * 
     * @test
     */
    public function test_will_not_map_invalid_data()
    {
        $this->expectException(InvalidArgumentException::class);

        $storage = new StorageAdapter([]);
        $mapper = new TurnipsMapper($storage);

        $mapper->findById(1);
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

Time: 00:00.050, Memory: 6.00 MB

OK (36 tests, 83 assertions)
```

## 完整程式碼
[設計模式不難，找回快樂而已，以大頭菜為例。](https://github.com/Kantai235/php-design-pattern)
- [技術部落格文章 - 資料對應](https://kantai235.github.io/DataMapper)
- [資料對應 原始碼](https://github.com/Kantai235/php-design-pattern/tree/master/DesignPatterns/Structural/DataMapper)
- [資料對應 測試](https://github.com/Kantai235/php-design-pattern/tree/master/Tests/Structural/DataMapperTest.php)

## 參考文獻
- [DesignPatternsPHP](https://github.com/domnikl/DesignPatternsPHP)
- [PHP 设计模式全集 2018](https://learnku.com/docs/php-design-patterns/2018)

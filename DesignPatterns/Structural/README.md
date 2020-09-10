# [結構型 Structural](/DesignPatterns/Structural)

## [轉接器模式 Adapter Pattern](/DesignPatterns/Structural/AdapterPattern)
轉接器模式，顧名思義會在兩個同功能但不同的規格的東西中，當作中間溝通的橋樑，就有點像是健康的大頭菜因為放超過一個禮拜，直接變成壞掉的大頭菜，兩個東西都是大頭菜，但規格上可能不太一樣，這時候我們就需要一個大頭菜轉接器，直接把健康的大頭菜給轉到壞掉。

## [橋接模式 Bridge Pattern](/DesignPatterns/Structural/BridgePattern)
橋接模式，將實作體系與抽象體系分離開來，讓兩者能各自更動各自演進，就有點像是大頭菜有分健康的大頭菜及壞掉的大頭菜，你的島上有這兩種大頭菜，但是健康的大頭菜過了一個禮拜都沒賣掉的話，他就會變成壞掉的大頭菜了。

## [組合模式 Composite Pattern](/DesignPatterns/Structural/CompositePattern)
組合模式，一種將物件一個一個處理，並且最後組合起來的模式，可以想像剛買到大頭菜時的夢想，經過每次漲跌所帶來的希望與絕望，究竟是充滿絕望的遞減型呢？還是致富關鍵的三期型呢？每次的價格異動，都代表著價格物件，最終賣出的鈴錢價格，是經過許多鈴錢價格物件所算出來的。

## [資料對應 Data Mapper](/DesignPatterns/Structural/DataMapper)
資料對應，這是一種常用於處理物件導向與資料庫資料的模式，與 `Repository` 不同，`Data Mapper` 主要處理的事單個物件本身，而 `Repository` 處理的是物件的集合。這次實作舉個例子，你在買大頭菜之前，需要有一個草圖去評估你要前往哪些島上買大頭菜，決定好之後再開始行動。

## [修飾模式 Decorator Pattern](/DesignPatterns/Structural/DecoratorPattern)
修飾模式，或者稱裝飾者模式，為物件動態增加新的方法，就想像你最初的大頭菜沒有想過他會壞掉，某天突然覺得讓大頭菜壞掉好像很好玩，但你不能把整個大頭菜砍掉重練，所以你希望可以不改變既有的大頭菜，在大頭菜額外再套上新的功能，那就是壞掉。

## [依賴注入 Dependency Injection](/DesignPatterns/Structural/DependencyInjection)
依賴注入模式，是控制反轉（Inversion of Control，縮寫為IoC）的一種實作方式，主要是將依賴物件丟給接收物件中，就像是你想要用大頭菜發財致富，但大頭菜有那麼多顆，你不可能每顆都記住單價、數量，所以你寫了一張便條紙，紀錄著大頭菜的型別、單價、數量，然後貼在大頭菜上。

## [外觀模式 Facade Pattern](/DesignPatterns/Structural/FacadePattern)
外觀模式，一種把複雜邏輯給包裝起來的一種模式，舉個例子來說，今天已經不單只是計算大頭菜了，而是你有個背包(Bag)要先放入鈴錢(Bells)，然後拿出鈴錢從曹賣(DaisyMae)手中購買大頭菜，並且把大頭菜賣給 Nook 商店(Store)，牽涉到許多的細節，透過外觀模式來將複雜的操作集中成幾個簡單的動作。

## [流暢介面 Fluent Interface](/DesignPatterns/Structural/FluentInterface)
流暢介面，常用於撰寫如同文章般容易閱讀的程式碼，如果以大頭菜來講，那麼在建立大頭菜的同時，希望可以順便賦予其鈴錢價格、數量，並且最終獲得的依舊是大頭菜物件。

## [享元模式 Flyweight Pattern](/DesignPatterns/Structural/FlyweightPattern)
享元模式，在定義上來說是共享物件，將相似的物件集中整理，減少記憶體上的使用，舉例來說每座島的大頭菜鈴錢價格都不同，有些朋友會送你大頭菜，但因為朋友太多了，所以需要有個地方集中放這些大頭菜，並且記錄起來，每個朋友都送你一組大頭彩，但你不能重複紀錄，不然你只收到一組大頭菜，帳上卻紀錄兩組，這樣就不好了。

## [代理模式 Proxy Pattern](/DesignPatterns/Structural/ProxyPattern)
代理模式，它可以作為需要被保護的物件的介面，若以檔案權限來比喻的話，就是對主要物件套上一層代理，你可以在代理上實作控制權限，像是其代理僅有讀取、執行的權限，並沒有刪除、修改的權限，並防止直接接觸實際物件，換作大頭菜來講的話，大頭菜的本質就是大頭菜，大頭菜就頂多提供數量堆積的功能，鈴錢的計算要在代理介面上實作。

## [註冊模式 Registry Pattern](/DesignPatterns/Structural/RegistryPattern)
註冊模式，如果應用程式內有非常多同樣的物件需要高度重複讀寫，就會去建立一個儲存器來負責管理這些同樣的物件，就有點像是你的大頭菜，會來自不同的島，每座的島菜價不同，這會導致你很難算出所賺到的鈴錢，所以如果每個大頭菜都需要登記註冊，然後有個集中管理的名冊，在管理大頭菜這件事上就能比較輕鬆。

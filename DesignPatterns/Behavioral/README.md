# [行為型 Behavioral](/DesignPatterns/Behavioral)

## [責任鏈模式 Chain of Responsibilities](/DesignPatterns/Behavioral/ChainOfResponsibilities)
責任鏈模式，有一系列的命令物件及處理物件，常見於需要被連續處理的地方上，舉例來說，假設今天收購箱、商店收購大頭菜時，多了一些條件，你必須先把大頭菜拿去收購箱收購，並且收購箱子會有鈴錢價格打 8 折的情形，剩下有多餘的大頭菜才能拿去給商店收購。

## [命令模式 Command Pattern](/DesignPatterns/Behavioral/CommandPattern)
命令模式，是一種將行為封裝起來裹上美好糖衣的一種模式，並將接收與執行分離出來，就有點像是把大頭菜買賣這件事，如果把買大頭菜、賣大頭菜這兩個動作封裝起來，變成一個命令，分開去執行。

## [疊代器模式 Iterator Pattern](/DesignPatterns/Behavioral/IteratorPattern)
疊代器模式，提供一種方法來簡單控制一個集合物件，這段過程並不會暴露該物件的來源或修改它，就有點像是你的背包(Bag)一樣，疊代器(Iterator)可以簡單控制你背包中的大頭菜(Turnips)以及鈴錢(Bells)。

## [中介者模式 Mediator Pattern](/DesignPatterns/Behavioral/MediatorPattern)
中介者模式，在兩個不同的封裝物件之間，作為中間進行交互的模式，可以減少物件之間的依賴關係，並且降低耦合性問題，舉例來說有背包(Bag)與商店(Store)這兩個物件，你會從背包(Bag)當中拿出鈴錢(Bells)去商店(Store)購買大頭菜(Turnips)，但它們應該要各自其職，不要太過於互相依賴，因此你會需要有個中間控制這些物件的中介者(Mediator)。

## [備忘錄模式 Memento Pattern](/DesignPatterns/Behavioral/MementoPattern)
備忘錄模式，在不破壞封裝物件的前提之下，提供物件一個「皇后殺手 第三爆彈：敗者成塵」的能力，物件在極度絕望的狀態下，把當前物件炸光光，並令時間往前倒退至上一個時空紀錄點的設計模式，跟吉良吉影的不同點在於命運會跟著被改變，被破壞的東西會恢復原狀。

## [空物件模式 Null Object Pattern](/DesignPatterns/Behavioral/NullObjectPattern)


## [觀察者模式 Observer Pattern](/DesignPatterns/Behavioral/ObserverPattern)


## [規格模式 Specification Pattern](/DesignPatterns/Behavioral/SpecificationPattern)


## [狀態模式 State Pattern](/DesignPatterns/Behavioral/StatePattern)


## [策略模式 Strategy Pattern](/DesignPatterns/Behavioral/StrategyPattern)


## [模板方法 Template Method](/DesignPatterns/Behavioral/TemplateMethod)


## [訪問者模式 Visitor Pattern](/DesignPatterns/Behavioral/VisitorPattern)


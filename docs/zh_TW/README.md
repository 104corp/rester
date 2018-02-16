# RESTer

RESTer 是一個方便呼叫 REST API 的函式庫。

此函式庫可以使用已經建好的 class 直接使用，開發者也可以自行組合內部各種元件，成為一個客製化的 SDK 。

## 快速開始

首先先使用 Composer 將套件加入：

```
composer require 104corp/rester 
```

接著直接使用 `ResterClient` ：

```php
use Corp104\Rester\ResterClient;
use Corp104\Rester\Api\Path;

// 初始化 ResterClient 物件
$resterClient = new ResterClient('http://127.0.0.1');
$resterClient->provisionMapping([
    'foo' => new Path('GET', '/foo'),
]);

// GET http://127.0.0.1/foo
$response = $resterClient->foo();

// PSR-7 Response
echo (string)$response->getBody();
```

一切順利的話，將會看到 Response 的內容。

## ResterClient

`ResterClient` 裡有一個 `Mapping` 物件，它負責存放名稱與 API 之間的對應關係。接著使用 Magic Method `__call` 來實作 method 名稱對應到 API 的方法，如此一來， ResterClient 就能有許多自定義的方法，來呼叫對應的 API。

`Mapping` 存放的 API 需實作 `ApiInterface` ，如 `Path` 、 `Endpoint` 或其他實作。

下面是一個混用的例子：

```php
$resterClient = new ResterClient('http://127.0.0.1');
$resterClient->provisionMapping([
    'foo' => new Path('GET', '/foo'),
    'bar' => new Endpoint('POST', 'https://www.some-url.com/bar'),
]);

// GET http://127.0.0.1/foo
$resterClient->foo();

// POST https://www.some-url.com/bar
$resterClient->bar();
```

## Parameters

呼叫 API 時，會需要帶三種參數：

> 以下使用原始碼的名稱做說明

* Binding
* QueryString
* ParsedBody

這三種參數的預設值都是空 array 。

### Binding

這個是指 path 中的變數，假如有個 API 是長這樣 `GET /users/{id}` ，而 `Binding` 的目的是把 `id` 替換成開發者想要的字串或內容。實際的範例程式碼如下：

```php
// API 定義為 GET http://127.0.0.1/foo/{bar}/{baz}
$resterClient = new ResterClient('http://127.0.0.1');
$resterClient->provisionMapping([
    'foo' => new Path('GET', '/foo/{bar}/{baz}'),
]);

// 使用 key-value 呼叫 API ： GET http://127.0.0.1/str1/str2
$resterClient->foo([
    'bar' => 'str1',
    'baz' => 'str2',
]);

// 按順序的方法代入 ： GET http://127.0.0.1/str3/str4
$resterClient->foo([
    'str3',
    'str4',
]);

// 如果沒有取代完全會丟 InvalidArgumentException
// $resterClient->foo();
```

### QueryString

QueryString 在第二個參數帶入，如：

```php
// GET http://127.0.0.1/?some=value
$resterClient->foo([], ['some' => 'value']);
```

### ParsedBody

ParsedBody 是 POST / PUT 等方法需要帶的內容，如：

```php
$data = [
    'name' => 'some-name',
];

$resterClient->foo([], [], $data);
```

> 目前包裝只使用 JSON ，未來會改成可調的。

## ResterCollection

如果有很多不同組的 API 需要分類或是撞名時， `ResterCollection` 可以幫助解決問題。

比方說有下列 API endpoint ：

```
GET http://127.0.0.1/users/{id}
POST http://127.0.0.1/users
PUT http://127.0.0.1/users/{id}
DELETE http://127.0.0.1/users/{id}

GET http://api.some-url.com/groups/{id}
POST http://api.some-url.com/groups
PUT http://api.some-url.com/groups/{id}
DELETE http://api.some-url.com/groups/{id}
```

我們可以把 `users` 與 `groups` 分成兩組，實際初始化的程式碼如下：

```php
$usersClient = new ResterClient('http://127.0.0.1');
$usersClient->provisionMapping([
    'get' => new Path('GET', '/users/{id}'),
    'create' => new Path('POST', '/users'),
    'update' => new Path('PUT', '/users/{id}'),
    'delete' => new Path('DELETE', '/users/{id}'),
]);

$groupsClient = new ResterClient('http://api.some-url.com');
$groupsClient->provisionMapping([
    'get' => new Path('GET', '/groups/{id}'),
    'create' => new Path('POST', '/groups'),
    'update' => new Path('PUT', '/groups/{id}'),
    'delete' => new Path('DELETE', '/groups/{id}'),
]);

$resterCollection = new ResterCollection();
$resterCollection->provisionCollection([
    'users' => $usersClient,
    'groups' => $groupsClient,
]);
```

使用方法如下：

```php
$userData = [
    // user data
];
$resterCollection->users->create([], [], $userData);

$groupData = [
    // group data
];
$resterCollection->groups->update([$groupId], [], $groupData);
```

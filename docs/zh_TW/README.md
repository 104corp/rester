# RESTer

RESTer 是一個方便呼叫 REST API 的函式庫。它可以使用已經建好的 [ResterClient](rester-client.md) class ，也可以自行組合內部各種元件，成為一個客製化的 SDK 。

## 快速開始

使用 Composer 將套件加入

```
$ composer require 104corp/rester 
```

接著使用 `ResterClient`

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

接著就能看得到 response 的內容。

## 了解更多

* [ResterClient](rester-client.md)
* [ResterCollection](rester-collection.md)
* [Api](api.md)
* [Plugins](plugins.md)
* [Hooks](hooks.md)
* [Error Handler](error-handler.md)
* [Asynchronous](asynchronous.md)

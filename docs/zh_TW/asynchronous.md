# Asynchronous

RESTer 支援非同步發送 request ，可以使用 Trait 來設定 client 為同步或非同步呼叫。

## Concept

RESTer 如何決定呼叫行為？

[`ResterClientTrait`](/src/Plugins/ResterClientTrait.php) 有個方法 `isAsynchronousCall()` ，它決定了 RESTer 將會用什麼樣的行為來呼叫 API 。判斷的方法如下：

2. 如果 Client 有設定非同步，則會使用非同步呼叫
3. 如果沒有任何設定，則會使用同步呼叫

`ResterClientTrait` 預設是同步呼叫。如果有需要，可以掛上 `AsynchronousTrait` 即可換成非同步呼叫。

使用範例如下：

```php
class MyClient
{
    use ResterClientTrait;
    use ResterMagicTrait;
    use AsynchronousTrait;
    
    // ...
}

$myClient = new MyClient();

// 非同步呼叫
$myClient->foo();
```

## Promise

同步呼叫會回傳 PSR-7 response 實例，而非同步呼叫則會回傳 `Promise` 實例。

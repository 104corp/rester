# Asynchronous

RESTer 支援非同步發送 request ，可以使用 Trait 來設定 client 為同步或非同步呼叫。

## Concept

RESTer 如何決定呼叫行為？

[`ResterClientTrait`](/src/Plugins/ResterClientTrait.php) 有個方法 `isAsynchronousCall()` ，它決定了 RESTer 將會用什麼樣的行為來呼叫 API 。判斷的方法如下：

2. 如果 Client 能有設定非同步，則會使用非同步呼叫
3. 如果沒有任何設定，則會使用同步呼叫

### Traits

預設 `ResterClientTrait` 預設並沒有任何 Trait 是設定同步或非同步呼叫，因此會是預設的同步呼叫。如果有需要，可以掛上對應的 Trait 即可有不同的行為，可以掛的 Trait 如下：

* `\Corp104\Rester\Plugins\SynchronousTrait` - 同步呼叫
* `\Corp104\Rester\Plugins\AsynchronousTrait` - 非同步呼叫

只要掛上面 trait 的話，都會有下面取得設定的方法：

* `isSynchronous()` - 是否為同步呼叫
* `isAsynchronous()` - 是否為非同步呼叫

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

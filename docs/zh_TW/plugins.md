# Plugins

RESTer 提供數種 trait ，提供給開發者方便自定義 client 。

## Traits

### AsynchronousTrait

Client 呼叫 API 預設是同步的，如果需要非同步，可以使用 `AsynchronousTrait` 來達成。

詳細資訊可參考 [Asynchronous](asynchronous.md) 內容。

### CollectionTrait

`CollectionTrait` 是 [`ResterCollection`](rester-collection.md) 的實作。

如果需要在 class 上加上 `__get()` 與 `__set()` 等 magic method 功能時，可以使用這個 trait 。

### MappingTrait

`MappingTrait` 是 [`ResterClient`](rester-client.md) 的實作之一。它提供了 mapping property 與解析 Request 的方法。

如果有想自定義解析 request 的話，可以基於這個 trait 實作。

### MockBuilderTrait

`MockBuilderTrait` 可以基於方法與回傳值來產生 Mock ，很適合用在 API 的 wrapper 上。

### ResterClientTrait

`ResterClientTrait` 是 [`ResterClient`](rester-client.md) 主要的實作。同時也是自定義 SDK 最常使用的 Trait 。

### ResterMagicTrait

`ResterMagicTrait` 實作了 `__call()` ，它背後實際上會呼叫 `ResterClientTrait` （或是自行實作）的 `call()` 方法。

## 自定義的範例

即使上面列出所有的 Trait ，可能還是會覺得不知道該如何自定義。以下介紹幾種情境示範可以如何自定義。

### 自定義建構方法

最基本的範例就是 `ResterClient` ：自定義建構方法，在建構時期決定 `baseUrl` 與 `options` 等重要資訊。只要 `provisionMapping` 之後，即可馬上使用。

```php
class MyClient implements
{
    use ResterClientTrait;
    use ResterMagicTrait;

    public function __construct($baseUrl = null, array $httpOptions = [])
    {
        $this->setBaseUrl($baseUrl);

        $this->httpOptions = array_merge(static::DEFAULT_HTTP_OPTIONS, $httpOptions);
    }
}
```

### 使用 MockBuilder

只要使用 MockBuilder ，就能擁有建立 Mock 的方法了。

```php
class MyClient implements
{
    use ResterClientTrait;
    use ResterMagicTrait;
    use MockBuilder;
}
```

### 自定義 __call()

假設我們想自定義 Magic Method `__call()` ，規則如下：

* 原本的 `__call()` 可以傳入三個參數，但我們想改成傳一個
* 當 API 方法是 GET / DELETE 時，參數會傳到 `$binding`
* 當 API 方法是 POST / PUT 時，參數會傳到 `$parsedBody`

```php
class MyClient implements
{
    use ResterClientTrait;

    public function __call($method, $args)
    {
        $params = $args[0] ?? [];

        if (!\is_array($params)) {
            throw new \InvalidArgumentException();
        }

        $binding = [];
        $parsedBody = [];

        /** @var Path $api */
        $api = $this->mapping->get($method);

        if (\in_array($api->getMethod(), ['GET', 'DELETE'], true)) {
            $binding = $params;
        } elseif (\in_array($api->getMethod(), ['POST', 'PUT'], true)) {
            $parsedBody = $params;
        } else {
            throw new \InvalidArgumentException();
        }

        return $this->call($method, $binding, [], $parsedBody);
    }
}
```

### Client + Collection 組合技

如果希望物件同時有 Client 自定義 method 之外，也希望有自定義的 property 的話，可以這樣定義：

```
class MyClient implements
{
    use ResterClientTrait;
    use ResterMagicTrait;
    use CollectionTrait;
}
```

### Client + Collection 組合技之二

如果 Collection 不想掛 Magic Method 的話，可以這樣寫：

```
class MyClient implements
{
    use ResterClientTrait;
    use ResterMagicTrait;
    use CollectionAwareTrait;
    
    public function sendSomeClient($method, $param)
    {
        return $this->collection->get('some')->$method($param);
    }
}
```

> 註： `CollectionAwareTrait` 在 `Support` namespace 下。

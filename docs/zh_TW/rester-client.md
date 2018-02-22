# ResterClient

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

## Mapping

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

## Lazy Loading

Mapping 實作了延遲載入。實際範例如下：

```php
$pathResolver = new PathResolver();
$endpointResolver = new EndpointResolver();

$resterClient = new ResterClient('http://127.0.0.1');
$resterClient->provisionMapping([
    'getFoo' => [$pathResolver, ['GET', '/foo']],
    'postFoo' => [$pathResolver, ['POST', '/foo']],
    'putFoo' => [$pathResolver, ['PUT', '/foo']],
    'deleteFoo' => [$pathResolver, ['DELETE', '/foo']],
    'getBar' => [$endpointResolver, ['GET', 'https://www.some-url.com/bar'],
    'postBar' => [$endpointResolver, ['POST', 'https://www.some-url.com/bar'],
    'putBar' => [$endpointResolver, ['PUT', 'https://www.some-url.com/bar'],
    'deleteBar' => [$endpointResolver, ['DELETE', 'https://www.some-url.com/bar'],
]);
```

延遲載入的細節可以參考 [Api](api.md) 文件。

## Options

`ResterClient` 在建構的時候可以帶入 Guzzle options ，如果有需要加 Header ，可以在建構的時候傳入。比方說，帶入 OAuth2 Token ：

```php
$options = [
    RequestOptions::HEADERS => [
        'Authorization' => $token,
    ],
];

$resterClient = new ResterClient('http://127.0.0.1', $options);
```

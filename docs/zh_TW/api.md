# Api

Api 必須住在 Mapping 裡，才能被 [`ResterClient`](rester-client.md) 呼叫到；住在 Mapping 的唯一條件就是要實作 [`ApiInterface`](/src/Api/ApiInterface.php) 。

它定義非常簡單，只要實作如何建立 Request 即可

```php
public function createRequest(
    array $binding = [],
    array $queryParams = [],
    array $parsedBody = []
): RequestInterface;
```

內建的 [`Path`](/src/Api/Path.php) 與 [`Endpoint`](/src/Api/Endpoint.php) 都有實作這個方法，差別只在 `Path` 只包含 path ，它會需要 Client 的 Base URL ； `Endpoint` 已經是完整的 URL 了。

## Customize

有幾種情況會需要自定義 Api ：

* 同一個 Api 名稱會因為不同的 context 而呼叫 endpoint 有些許不同，如版本
* `QueryParams` 、 `Header` 等有固定傳入值，如 `QueryParams` 想加入自定義的呼叫來源： `CallBy=MyClient`
* 自定義的包裝格式，如 XML / YAML / 自定義的 JSON 包裝等

如果自定義的 Api 需要使用延遲載入的話，則需要實作 Resolver 或使用 Closure 。

## Concept of Resolver 

Resolver 的實作與原理很單純，只要繼承 [`Resolver`](/src/Resolver.php) ，並實作 `resolve` 即可。 `Mapping` 在 `get()` 時，只要發現傳入的值是 array ，即會把第一個值作為 callable ，第二個值做為 parameters 使用 `call_user_func_array()` 執行。

```php
// $api is Array
$callable = $api[0];
$parameters = $api[1];

$apiInstance = call_user_func_array($callable, $parameters);
```

也因此 Resolve 不會把 `resolve` 定義成抽象，因為 Api 可以自定義， parameter 就有可能不是固定的，並且它可透過 PHP 7 的型別檢查來確保傳入值是正確的。

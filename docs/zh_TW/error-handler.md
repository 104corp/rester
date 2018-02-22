# Error Handler

RESTer 的錯誤處理方法與 [Hooks](hooks.md) 處理 Response 類似。

RESTer 會在實際發送 request 的時候，使用 try cache 包起來，而會接到的 Exception 主要都會是 Guzzle Exception 。接著再把接到的 exception 物件交給 `handleException()` 處理。

```php
try {
    $response = $this->httpClient->send($request, $this->httpOptions);
} catch (RequestException $e) {
    throw $this->handleException($e, $name);
}
``` 

因此實務上，只要覆寫 `handleException()` 即可把 exception 接手自己處理。

以下是處理不同 status code 的 exception 範例：

```php
protected function handleException(RequestException $exception, string $name): Exception
{
    switch ($exception->getCode()) {
        case 404:
        case 405:
            return new InvalidApiException('Api is invalid', $exception->getCode, $exception);
        case 500:
            return new ServerException('Something wrong', $exception->getCode, $exception);
        default:
            return new MyException('Something wrong', $exception->getCode, $exception);
    }
}
```

**注意**：因為 type hint 要求要回傳 Exception ，因此無論是 throw 或是 return ，最終例外一定會被丟出來。

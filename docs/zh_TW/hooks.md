# Hooks

`ResterClientTrait` 提供了五個 hook 讓開發者可以不同階段可以做特定任務，其中有分成同步與非同步兩種類型。

同步相關的 hooks 如下

* `beforeSendRequest` - 送 Request 之前
* `afterSendRequest` - 送 Request 之後
* `transformResponse` - 轉換 Response

非同步相關的 hooks 如下

* `afterSendRequestAsync` - 送 Request 之前
* `transformPromise` - 轉換 Promise

## Example - 1

每次送 Request 與取得 Response 都寫 log ，方便 debug ：

```php
protected function beforeSendRequest(RequestInterface $request, string $name)
{
    $method = $request->getMethod();
    $uri = $request->getUri();

    $this->logger->info("{$method} {$uri}");
}

protected function transformResponse(ResponseInterface $response, string $name)
{
    $body = (string)$response->getBody();

    $this->logger->info("Response: {$body}");
}
```

## Example - 2

得到 Response 轉換成 SDK 自己定義的 Response ：

```php
protected function transformResponse(ResponseInterface $response, string $name)
{
    $responseBody = (string)$response->getBody();

    return new CustomResponse($responseBody);
}
```

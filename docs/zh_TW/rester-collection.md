# ResterCollection

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

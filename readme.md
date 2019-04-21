## PassPort Auth2.0 API
基于`Laravel Passport`实现`OAuth2.0`授权   封装`Resource` 完成统一`API`
 
## 下载项目

## 设置env项目配置

```
$ cp .env.example .env
``` 

## 扩展安装

```
$ composer install
```

## 数据库配置

```
$ php artisan migrate
```

> 数据库连接配置开发环境

## 生成访问秘钥

```
$ php artisan passport:install
```

## 创建客户端

```
$ php artisan passport:client --password --name='apkbus-ios'
```

## 执行项目初始化信息
```
$ php artisan thinker
$ namespace App\Models;
$ factory(User::class,10)->create();
```

## postman整体配置
![002](public/screenshot/002.png)

## 登录token(数据库分配的客户端id&&secret)
![001](public/screenshot/001.png)

## token刷新(refresh_token)
![003](public/screenshot/003.png)

## 统一成功返回
```
{
    "status": "success",
    "code": 200,
    "message": "请求成功"
}
```

## 统一错误返回
```
{
    "status": "error",
    "code": 401,
    "message": "用户认证失败"
}
```

## 统一资源返回(其他格式参考Api Resource)
```
{
    "data": {
        "id": 1,
        "name": "Joshua Torphy",
        "email": "napoleon10@example.net",
        "created_at": "2019-04-19 06:48:00"
    }
}
```

## 统一资源集合返回(分页)
```
{
    "data": {
        "list": [
            {
                "id": 1,
                "name": "Joshua Torphy",
                "email": "napoleon10@example.net",
                "created_at": "2019-04-19 06:48:00"
            },
            {
                "id": 2,
                "name": "Yessenia Ebert PhD",
                "email": "ignatius87@example.com",
                "created_at": "2019-04-19 06:48:00"
            },
            {
                "id": 3,
                "name": "Dr. Samson Rath IV",
                "email": "kortiz@example.net",
                "created_at": "2019-04-19 06:48:00"
            },
            {
                "id": 4,
                "name": "Julien Swift",
                "email": "laurie43@example.net",
                "created_at": "2019-04-19 06:48:00"
            }
        ],
        "count": 4
    },
    "links": {
        "first": "http://laravel-passport.site/api/users?page=1",
        "last": "http://laravel-passport.site/api/users?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "http://laravel-passport.site/api/users",
        "per_page": 15,
        "to": 4,
        "total": 4
    }
}
```
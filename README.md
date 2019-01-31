<h2 align="center">HttpClient</h2>
<p align="center">这是一个基于guzzle进行二次封装的简单Http客户端。</p>

<p align="center">JimCY [me@jinfeijie.cn] </p>

<p align="center">
<img src="https://travis-ci.org/jinfeijie/HttpClient.svg?branch=master">
<img src="https://img.shields.io/librariesio/github/jinfeijie/HttpClient.svg?style=popout">
<img src="https://img.shields.io/github/license/jinfeijie/HttpClient.svg?style=popout">
</p>


* 功能（以下功能可自由组合）
- [x] 同步请求（互斥于异步请求）
- [X] 异步请求（互斥于同步请求）
- [X] 设置请求头
- [X] 设置Cookie
- [X] 设置表单参数
- [X] 设置url参数
- [X] 设置认证信息
- [X] 设置超时时间
- [X] 设置是否跟随跳转
- [X] 设置数据格式解析
- [X] 支持POST,GET,DELETE,HEAD,PUT,PATCH

* 安装
```
composer require jinfeijie/http-client -vvv
```


* 使用方法
    1. 同步请求
        ```
        $result  = (new HttpClient('https://jinfeijie.cn'))
            ->setAuth(['jinfeijie','whoami'])
            ->send();
        ```
    2. 异步请求
        1. 手动解析
            ```
            $promise  = (new AsyncClient('https://jinfeijie.cn'))
                ->setAuth(['jinfeijie','whoami'])
                ->send();
            $result = (string)$promise->wait()->getBody();
            ```
        2. 手动解析
            ```
            $result  = (new AsyncClient('https://jinfeijie.cn'))
                ->setAuth(['jinfeijie','whoami'])
                ->getContent();
            ```
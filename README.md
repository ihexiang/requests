# requests



#### 介绍
PHP Requests 支持 GET、POST、PUT、PATCH、DELETE、HEAD、OPTIONS 等方法



#### 运行环境

- PHP版本 ( >= 5.4 )
- composer



#### 安装

composer require ihexiang/requests v1.0.0


#### 支持的方法
    
- GET &nbsp;&nbsp;[示例](./example/get.php)
- POST &nbsp;&nbsp;[示例](./example/post.php)
- PUT &nbsp;&nbsp;[示例](./example/put.php)
- PATCH &nbsp;&nbsp;[示例](./example/patch.php)
- DELETE &nbsp;&nbsp;[示例](./example/delete.php)
- HEAD &nbsp;&nbsp;[示例](./example/head.php)
- OPTIONS &nbsp;&nbsp;[示例](./example/options.php)

#### 响应 Response

- 每一个请求都返回一个响应对象 response

- 成员属性

    - header 响应头信息
    - http_code HTTP code 码
    - body 响应内容体
    - erron 错误码
    - error 错误消息

- 成员方法

    - content() 获取文本类型的 响应内容
    - toArray(dataType) 获取数组类型的 响应内容



#### 示例

``` 
<?php
use iHexiang\Requests\Requests;

    //1.简单示例
    echo Requests::get('https://xxx.example/test.api');


    //2.返回响应示例
    $response = Requests::get('https://xxx.example/test.api');
    if(!$response->http_code){
        echo $response->error;
    }else{

        //注：以下2种效果是一样的
        echo $response;
        echo $response->content();

        //打印数组
        //注：接口必须返回 json 或 xml 格式数据
        //var_dump($response->toArray('json'));
        //var_dump($response->toArray('xml'));
    }

    //3.全部字段使用示例
    $response = Requests::get(
        'https://xxx.example/test.api',
        ['Content-Type: text/html;charset=utf-8'],
        ['timeout'=>10]
    );


    if(!$response->http_code){
        echo $response->error;
    }else{

        //注：以下2种效果是一样的
        echo $response;
        echo $response->content();

        //打印数组
        //注：接口必须返回 json 或 xml 格式数据
        //var_dump($response->toArray('json'));
        //var_dump($response->toArray('xml'));
    }
    
   
``` 

#### LICENSE
Apache-2.0
<?php
/**
 * get请求 示例文件
 *
 * @author      he xiang <ihexiang@163.com>
 * @version     1.0.0
 */

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

    //4: $options 参数支持示例 、其它请求方法一样使用

    //4.1 超时时间 timeout
    $response = Requests::get(
        'https://xxx.example/test.api',
        ['Content-Type: text/html;charset=utf-8'],
        ['timeout'=>10]
    );

    //4.2 auth
    $response = Requests::get(
        'https://xxx.example/test.api',
        ['Content-Type: text/html;charset=utf-8'],
        ['auth'=>['USER_NAME','USER_PASS']]
    );

    //4.3 user_agent
    $response = Requests::get(
        'https://xxx.example/test.api',
        ['Content-Type: text/html;charset=utf-8'],
        ['user_agent'=>'Mozilla/5.0 (Linux; U; Android 2.3.7; zh-cn;..']
    );

    //4.3.1 代理地址 proxy
    $response = Requests::get(
        'https://xxx.example/test.api',
        ['Content-Type: text/html;charset=utf-8'],
        ['proxy'=>['192.168.0.1']]
    );

    //4.3.2 代理地址&端口 proxy
    $response = Requests::get(
        'https://xxx.example/test.api',
        ['Content-Type: text/html;charset=utf-8'],
        ['proxy'=>['192.168.0.1',8080]]
    );

    //4.4 来源页面地址 referer
    $response = Requests::get(
        'https://xxx.example/test.api',
        ['Content-Type: text/html;charset=utf-8'],
        ['referer'=>'https://xxx.example/1.html']
    );

    //4.4 证书地址 cainfo
    $response = Requests::get(
        'https://xxx.example/test.api',
        ['Content-Type: text/html;charset=utf-8'],
        ['cainfo'=>'https://xxx.example/1.pem']
    );



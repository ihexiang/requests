<?php
/**
 * head 请求 示例文件
 *
 * @author      he xiang <ihexiang@163.com>
 * @version     1.0.0
 */

use iHexiang\Requests\Requests;

    //1.简单示例
    echo Requests::head('https://xxx.example/test.api');


    //2.返回响应示例
    $response = Requests::head('https://xxx.example/test.api');
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
    $response = Requests::head(
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
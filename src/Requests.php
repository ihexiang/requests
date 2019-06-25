<?php
namespace iHexiang\Requests;

use iHexiang\Requests\Response;

class Requests
{


    /**
     * GET method
     *
     * @var string
     * */
    const GET = 'GET';


    /**
     * POST method
     *
     * @var string
     * */
    const POST = 'POST';


    /**
     * PUT method
     *
     * @var string
     * */
    const PUT = 'PUT';


    /**
     * PATCH method
     *
     * @var string
     * */
    const PATCH = 'PATCH';


    /**
     * DELETE method
     *
     * @var string
     * */
    const DELETE = 'DELETE';


    /**
     * HEAD method
     *
     * @var string
     * */
    const HEAD = 'HEAD';


    /**
     * OPTIONS method
     *
     * @var string
     * */
    const OPTIONS = 'OPTIONS';

    private function __construct()
    {

    }



    /**
     * get 请求方法
     *
     * @param string $url
     * @param array $headers
     * @param array $options
     * @return Response
     * */
    public static function get($url, $headers = [], $options = [])
    {
        return self::request($url,$headers,null,self::GET,$options);
    }


    /**
     * post 请求方法
     *
     * @param string $url
     * @param array $headers
     * @param array $data
     * @param array $options
     * @return Response
     * */
    public static function post($url, $headers = [], $data = [], $options = [])
    {
        return self::request($url,$headers,$data,self::POST,$options);
    }


    /**
     * put 请求方法
     *
     * @param string $url
     * @param array $headers
     * @param array $data
     * @param array $options
     * @return Response
     * */
    public static function put($url, $headers = [], $data = [], $options = [])
    {
        return self::request($url,$headers,$data,self::PUT,$options);
    }


    /**
     * patch 请求方法
     *
     * @param string $url
     * @param array $headers
     * @param array $data
     * @param array $options
     * @return Response
     * */
    public static function patch($url, $headers = [], $data = [], $options = [])
    {
        return self::request($url,$headers,$data,self::POST,$options);
    }


    /**
     * delete 请求方法
     *
     * @param string $url
     * @param array $headers
     * @param array $options
     * @return Response
     * */
    public static function delete($url, $headers = [], $options = [])
    {
        return self::request($url,$headers,null,self::DELETE,$options);
    }


    /**
     * head 请求方法
     *
     * @param string $url
     * @param array $headers
     * @param array $options
     * @return Response
     * */
    public static function head($url, $headers = [], $options = [])
    {
        return self::request($url,$headers,null,self::HEAD,$options);
    }


    /**
     * options 请求方法
     *
     * @param string $url
     * @param array $headers
     * @param array $data
     * @param array $options
     * @return Response
     * */
    public static function options($url, $headers = [], $data = [], $options = [])
    {
        return self::request($url,$headers,$data,self::OPTIONS,$options);
    }



    /**
     * 请求方法
     *
     * @param string $url
     * @param array $headers
     * @param array $data
     * @param string $method
     * @param array $options
     * @return Response
     * */
    public static function request($url, $headers = [], $data = [], $method = self::GET, $options = [])
    {

        $ch = curl_init();

        //设置 headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        //https
        if(stripos($url,'https://') != false){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_SSLVERSION, 1);
        }

        //返回内容
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //返回请求头
        curl_setopt($ch, CURLOPT_HEADER, true);

        //返回Body
        curl_setopt($ch, CURLOPT_NOBODY, 0);

        curl_setopt($ch, CURLOPT_URL, $url);

        self::parse_data($ch,$method,$data);

        self::parse_options($ch,$options);

        //读取获取内容
        $responses = curl_exec($ch);

        //读取状态
        $status = curl_getinfo($ch);

        //读取错误号
        $errno  = curl_errno($ch);

        //读取错误详情
        $error = curl_error($ch);

        //关闭连接
        curl_close($ch);

        $response = new \iHexiang\Requests\Response();

        if($errno == 0 && isset($status['http_code'])){

            $response->header = substr($responses, 0, $status['header_size']);
            $response->body = substr($responses, $status['header_size']);
            $response->http_code = $status['http_code'];

        }else{
            $response->errno = $errno;
            $response->error = $error;
        }

        return $response;
    }



    /**
     * 解析 option
     *
     * @param resource $ch
     * @param array $options
     * @return void
     * */
    protected static function parse_options($ch,$options = []){

        //设置超时时间
        if(!empty($options['timeout'])){
            curl_setopt($ch, CURLOPT_TIMEOUT, $options['timeout']);
        }

        //auth
        if(!empty($options['auth'])){
            curl_setopt ($ch, CURLOPT_USERNAME, $options['auth'][0]);
            curl_setopt ($ch, CURLOPT_PASSWORD, $options['auth'][1]);
        }

        //设置模拟用户使用的浏览器
        if(!empty($options['user_agent'])){
            curl_setopt($ch, CURLOPT_USERAGENT, $options['user_agent']);
        }

        //代理地址&端口
        if((!empty($options['proxy'])) && (!empty($options['proxy'][0]))){
            curl_setopt ($ch, CURLOPT_PROXY, $options['proxy'][0]);
            if(!empty($options['proxy'][1])){
                curl_setopt ($ch, CURLOPT_PROXYPORT, $options['proxy'][1]);
            }
        }

        //来源页面地址
        if(!empty($options['referer'])){
            curl_setopt ($ch, CURLOPT_REFERER, $options['referer']);
        }

        //证书地址
        if(!empty($options['cainfo'])){
            curl_setopt ($ch, CURLOPT_CAINFO, $options['cainfo']);
        }

    }


    /**
     * 解析 data
     *
     * @param resource $ch
     * @param string $method
     * @param array $data
     * @return void
     * */
    protected static function parse_data($ch, $method, $data = []){

        //处理文件上传
        if(is_array($data) && (!empty($data))){
            foreach ($data as $key=>$val){
                if(stripos($val,'@') === 0){
                    if(version_compare(PHP_VERSION,'5.5.0', '>=')){
                        $data[$key] = new \CURLFile(realpath(trim($val,'@')));
                    }else{
                        $data[$key] = '@'.realpath($val);
                    }
                }
            }
        }

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
    }

}
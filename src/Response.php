<?php
/**
 * Response
 *
 * @author      he xiang <ihexiang@163.com>
 * @version     1.0.0
 */

namespace iHexiang\Requests;


class Response
{


    public $header = '';
    public $http_code = 0;
    public $body = '';
    public $erron = 0;
    public $error = '';



    function __construct()
    {

    }

    function __toString()
    {
        return $this->body;
    }


    public function content()
    {
        return $this->body;
    }


    public function toArray($dataType)
    {
        switch ($dataType){
            case 'json':
                try{
                    return json_decode($this->body,true);
                }catch (\Exception $e){
                    return [];
                }
                break;
            case 'xml':
                try{
                    return simplexml_load_string($this->body);
                }catch (\Exception $e){
                    return [];
                }
                break;
            default:
                return [];
        }
    }




}
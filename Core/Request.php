<?php

namespace app\core;

class Request
{
    public function isGet()
    {
        return $this->getMethod() === 'get';
    }

    public function isPost()
    {
        return $this->getMethod() === 'post';
    }

    public function getPath(){
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path,"?");
        if($position === false)return $path;
        else return substr($path,0,$position);
    }
    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
    
    public function getBody()
    {
        $body = [];
        if($this->getMethod() === 'get'){
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET,$key,FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        
        if($this->getMethod() === 'post'){
            foreach ($_POST as $key => $value) {
                echo "I am here";
                $body[$key] = filter_input(INPUT_POST,$key,FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;
    }
}
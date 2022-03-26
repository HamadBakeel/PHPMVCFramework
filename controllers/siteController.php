<?php
namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use http\Params;

class SiteController extends Controller {
    public function home(){
        $params = [
            "name"=> "Hamad Bakeel"
        ];
        return $this->render("home",$params);
    }
    public static function handleContact(Request $request){

        $body = $request->getBody();
        echo "<pre>";
        var_dump($body);
        return "Handling Submitted Dataaa";
    }

    public  function contact(){
        return $this->render("contact",[]);
    }

}
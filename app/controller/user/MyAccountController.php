<?php
namespace app\controller\user;

use ulole\core\classes\Response;

class MyAccountController {

    public static function myAccountHandler() {
        $out = [
            "done"=>false,
            "errorMessage"=>false,
            "redirect"=>false
        ];

        $out["type"] = USER["type"];
        $out["name"] = USER["username"];
        $out["done"] = true;


        return Response::returnJson($out);
    }

}
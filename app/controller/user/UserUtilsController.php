<?php
namespace app\controller\user;

use ulole\core\classes\Response;

class UserUtilsController {
    public static function search() {
        global $_POST;
        $out = [
            "done"=>false,
            "errorMessage"=>false,
            "redirect"=>false,
            "user"=>[

            ]
        ];

        foreach ((new \databases\UserTable)->select("*")->where("username", " LIKE ", "%".$_POST["search"]."%")->limit(10)->get() as $obj) {
            array_push($out["user"], [
                "username"=>$obj["username"],
                "profileimage"=>$obj["profileimage"]
            ]);
        }

        return Response::returnJson($out);

        //$_ROUTEVAR
    }
}
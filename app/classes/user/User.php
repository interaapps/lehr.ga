<?php
namespace app\classes\user;

use \databases\UserTable;
use \app\classes\utils\Security;

use \ulole\core\classes\util\cookies\Session;

class User {

    public static function login($username, $password, $setSession=true) {
        $qu = (new UserTable)->select("*")->where("username", $username)->andwhere("password", Security::hashPassword($username.$password))->get();
        if (count($qu) > 0) {
            if ($setSession) {
                $session = new Session("user");
                foreach ($qu as $obj)
                    $session->set("userid", $obj["id"]);
                $session->save();
            }
            return true;
        }
        return false;
    }

    public static function register($username, $password, $type) {
        echo count((new UserTable)->select("*")->where("username", $username)->get());
        if (count((new UserTable)->select("*")->where("username", $username)->get()) == 0) {
            $user = new UserTable;
            $user->username = $username;
            echo Security::hashPassword($username.$password);
            $user->password = Security::hashPassword($username.$password);
            $user->type = $type;
            $user->profileimage = "/assets/images/nopb.png";
            return [
                "query"=>$user->save(),
                "id"=>$user->getObject()->lastInsertId(),
                "username"=>$username,
                "type"=>$type
            ];
        }
        return false;
    }

    public static function userData() {
        $session = new Session("user");
        if ($session->isset("userid")){
            $qu = (new UserTable)->select("*")->where("id", $session->get("userid"))->first();
            if ($qu["id"] !== null)
                return $qu;
        }
        return false;
    }


}
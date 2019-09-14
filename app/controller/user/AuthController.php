<?php

namespace app\controller\user;

use app\classes\user\User;
use ulole\core\classes\Request;
use ulole\core\classes\Response;
use ulole\core\classes\util\cookies\Session;

class AuthController {

    public static function loginPage() {
        view("user/auth/login.php");
    }

    public static function loginHandler() {
        global $_POST;
        $returnArray = [
            "done" => false,
            "errorMessage" => 0,
            "redirect" => false
        ];
        if (isset($_POST["username"]) && isset($_POST["password"])) {
            if (User::login($_POST["username"], $_POST["password"], true)) {
                $returnArray["done"] = true;
                $returnArray["redirect"] = "/";
            } else {
                $returnArray["done"] = false;
                $returnArray["errorMessage"] = "Invalid password";
            }
        } else {
            $returnArray["done"] = false;
            $returnArray["errorMessage"] = "Invalid request";
        }
        return Response::returnJson($returnArray);



    }

    public static function redirectToLogin() {
        Response::redirect("/auth/login");
    }

    public static function registerPage() {

    }

    /*
     * NOT READY
     * */

    public static function registerHandler() {
        exit();
        global $_POST;
        $returnArray = [
            "done" => false,
            "errorMessage" => 0,
            "redirect" => false
        ];
        if (isset($_POST["name"]) && isset($_POST["password"])) {
            $login = User::register($_POST["name"], $_POST["name"], "STUDENT");
            //if ($login !== )
        }
    }

}
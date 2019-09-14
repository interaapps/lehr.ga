<?php
namespace app\controller\courses;

use databases\CoursePostsTable;
use databases\CourseUserTable;
use databases\UserTable;
use databases\WorksheatSubmitsTable;
use ulole\core\classes\Response;

class PostController {

    public static function postPage() {
        global $_ROUTEVAR;
        if (CourseController::imInCourse($_ROUTEVAR[1]))
            \view("courses/postPage", [
                "courseid"=>$_ROUTEVAR[1],
                "pageid"=>$_ROUTEVAR[2],
                "isMine"=> (new CoursePostsTable())->select("user")->where("id", $_ROUTEVAR[2])->first()["user"] == USER["id"],
                "type"=>(new CoursePostsTable())->select("type")->where("id", $_ROUTEVAR[2])->first()["type"]
            ]);
        else
            Response::redirect("/");
    }

    public static function postHandler() {
        global $_ROUTEVAR;
        $out = [
            "done"=>false,
            "errorMessage"=>false,
            "redirect"=>false,
        ];
        $db = (new CoursePostsTable())->select("*")->where("id", $_ROUTEVAR[2])->andwhere("course", $_ROUTEVAR[1])->first();
        if (CourseController::imInCourse($_ROUTEVAR[1])) {
            if ($db["id"] !== null) {
                $out["done"] = true;
                $out["data"] = [
                    "user" => (new UserTable())->select("*")->where("id", $db["user"])->first()["username"],
                    "type" => $db["type"],
                    "created" => $db["created"],
                    "id" => $db["id"],
                    "contents" => json_decode($db["contents"])
                ];
            } else
                $out["errorMessage"] = "Not found";
        }
        return Response::returnJson($out);
    }

    public static function deletePost() {
        global $_ROUTEVAR;
        $out = [
            "done"=>false,
            "errorMessage"=>false,
            "redirect"=>false,
        ];

        $db = (new CoursePostsTable())->select("*")->where("id", $_ROUTEVAR[2])->andwhere("course", $_ROUTEVAR[1])->andwhere("user", USER["id"])->first();

        if ( $db["id"] !== null ) {
            (new CoursePostsTable())->delete()->where("id", $_ROUTEVAR[2])->andwhere("course", $_ROUTEVAR[1])->andwhere("user", USER["id"])->run();
            $out["done"] = true;
            $out["redirect"] = "/course/".$db["course"];
        }

        return Response::returnJson($out);
    }


}
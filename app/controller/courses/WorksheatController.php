<?php
namespace app\controller\courses;

use databases\CoursePostsTable;
use databases\CourseUserTable;
use databases\UserTable;
use databases\WorksheatSubmitsTable;
use ulole\core\classes\Response;

class WorksheatController {

    public static function submitsPage() {
        global $_ROUTEVAR;
        $db = (new CoursePostsTable())->select("*")->where("id", $_ROUTEVAR[2])->andwhere("course", $_ROUTEVAR[1])->andwhere("user", USER["id"])->first();
        if ($db["id"] != null)
            view("courses/submits", [
                "pageid"=>$_ROUTEVAR[2],
                "courseid"=>$_ROUTEVAR[1],
                "type"=>$db["type"]
            ]);
        else
            Response::redirect("/");
    }

    public static function submitsHandler() {
        global $_ROUTEVAR;
        $out = [
            "done"=>false,
            "errorMessage"=>false,
            "redirect"=>false,
            "data"=>[]
        ];
        $db = (new CoursePostsTable())->select("*")->where("id", $_ROUTEVAR[2])->andwhere("course", $_ROUTEVAR[1])->andwhere("user", USER["id"])->first();

        if ($db["id"] != null) {
            $out["done"] = true;
            foreach ( (new WorksheatSubmitsTable())->select("*")->where("worksheat", $_ROUTEVAR[2])->get() as $obj ) {
                array_push($out["data"], [
                    "user"=>(new UserTable())->select("username")->where("id", $obj["user"])->first()["username"],
                    "contents"=>json_decode($obj["contents"])
                ]);
            }
        }
        return Response::returnJson($out);
    }


    public static function submitWorksheat() {
        global $_POST,
               $_ROUTEVAR;
        $contents = [];
        foreach ($_POST as $key=>$value)
            $contents[$key] = $value;

        if (CourseController::imInCourse($_ROUTEVAR[1])) {

            if ((new CoursePostsTable())->select("id")
                    ->where("id", $_ROUTEVAR[2])
                    ->andwhere("course", $_ROUTEVAR[1])
                    ->andwhere("type", "WORKSHEAT")->first()["id"] != null) {

                $db = new WorksheatSubmitsTable();
                $db->user = USER["id"];
                $db->worksheat = $_ROUTEVAR[2];
                $db->contents = json_encode($contents);
                $db->save();
                Response::redirect("/course/".$_ROUTEVAR[1]);
            }
        }
    }
    
}
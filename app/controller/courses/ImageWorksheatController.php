<?php
namespace app\controller\courses;

use ulole\core\classes\Response;

class ImageWorksheatController {
    
    public static function imageSubmit() {
        global $_ROUTEVAR,
               $_POST;
        $out = [
            "done"=>false,
            "errorMessage"=>false,
            "redirect"=>false
        ];
        if (CourseController::imInCourse($_ROUTEVAR[1])) {
            if ( (new \databases\CoursePostsTable)
                    ->select("*")
                    ->where("id", $_ROUTEVAR[2])
                    ->andwhere("course", $_ROUTEVAR[1])->first()["id"] != null && isset($_POST["image"])) {
                $db = new \databases\ImageWorksheatSubmitsTable;
                $db->post = $_ROUTEVAR[2];
                $db->user = USER["id"];
                $db->image = $_POST["image"];
                $db->save();
                $out["done"] = true;
                $out["redirect"] = "/course/".$_ROUTEVAR[1];
            }
        }
        return Response::returnJson($out);
    }

    public static function submitsHandler() {
        global $_ROUTEVAR;
        $out = [
            "done"=>false,
            "errorMessage"=>false,
            "redirect"=>false,
            "data"=>[]
        ];
        $db = (new \databases\CoursePostsTable())->select("*")
                ->where("id", $_ROUTEVAR[2])
                ->andwhere("course", $_ROUTEVAR[1])
                ->andwhere("user", USER["id"])
                ->first();
        
        if ($db["id"] != null) {
            $out["done"] = true;
            foreach ( (new \databases\ImageWorksheatSubmitsTable())
                            ->select("*")
                            ->where("post", $_ROUTEVAR[2])
                            ->get() as $obj 
            ) {
                array_push($out["data"], [
                    "user"=>(new \databases\UserTable())->select("username")->where("id", $obj["user"])->first()["username"],
                    "image"=>$obj["image"]
                ]);
            }
        }
        return Response::returnJson($out);
    }

}
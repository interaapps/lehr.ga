<?php
namespace app\controller\courses;

use app\classes\files\Folder;
use app\classes\user\UserTypes;
use databases\CoursesTable;
use databases\CoursePostsTable;
use databases\CourseUserTable;
use databases\UserTable;
use ulole\core\classes\Response;

class CourseController {
    public static function coursePage() {
        global $_ROUTEVAR;
        if (self::imInCourse($_ROUTEVAR[1]))
            \view("courses/coursePage", [
                "pageid"=>$_ROUTEVAR[1],
                "isMine"=>NewPostController::isMy($_ROUTEVAR[1])
            ]);
        else
            Response::redirect("/");
    }

    public static function courseHandler() {
        global $_ROUTEVAR;
        $out = [
            "done"=>false,
            "errorMessage"=>false,
            "redirect"=>false,
            "posts"=> []
        ];

        $db = (new CoursesTable)->select("*")->where("id", $_ROUTEVAR[1])->first();

        if ($db["id"] !== null && self::imInCourse($_ROUTEVAR[1])) {
            $out["done"] = true;
            $out["title"] = $db["name"];

            foreach ((new CoursePostsTable())->select("*")->where("course", $db["id"])->get() as $obj) {

                $contents = json_decode($obj["contents"]);
                if ($contents != null) {
                    if (isset($contents->text))
                        $conents["text"] = ((($contents->text !== null) ? ($contents->text) : ""));

                    if (isset($contents->title))
                        $conents["title"] = ((($contents->title !== null) ? ($contents->title) : ""));
                    
                    if (isset($contents->image))
                        $conents["image"] = ((($contents->image !== null) ? ($contents->image) : ""));
                    array_push($out["posts"], [
                        "user" => (new UserTable())->select("*")->where("id", $obj["user"])->first()["username"],
                        "type" => $obj["type"],
                        "created" => $obj["created"],
                        "id" => $obj["id"],
                        "contents" => $contents
                    ]);
                }
            }
        }

        return Response::returnJson($out);
    }

    public static function peopleHandler() {
        global $_ROUTEVAR;
        $out = [
            "done"=>false,
            "errorMessage"=>false,
            "redirect"=>false
        ];

        if (self::imInCourse($_ROUTEVAR[1])) {
            $out["user"] = [];
            foreach ((new CourseUserTable())->select("*")->where("course", $_ROUTEVAR[1])->get() as $obj) {
                $userdata = (new UserTable())->select("*")->where("id", $obj["user"])->first();
                array_push($out["user"], [
                    "type"=>$obj["type"],
                    "username"=>$userdata["username"],
                    "profileimage"=>$userdata["profileimage"]
                ]);
            }
        }

        return Response::returnJson($out);
    }

    public static function newCourse() {
        global $_POST;
        $out = [
            "done"=>false,
            "errorMessage"=>false,
            "redirect"=>false
        ];
        if (
            isset($_POST["name"]) &&
            (\USER["type"] == "TEACHER" || \USER["type"] == "ADMIN") &&
            USER !== false
        ) {
            $db = new CoursesTable();
            $db->name = $_POST["name"];
            $db->save();
            $courseId = $db->getObject()->lastInsertId();

            $userDb = new CourseUserTable();
            $userDb->user  = \USER["id"];
            $userDb->course = $courseId;
            $userDb->type  = UserTypes::TEACHER;
            $userDb->save();
            $out["redirect"] = "/course/".$courseId;
            $out["done"]     = true;
        } else
            $out["errorMessage"] = "Invalid request, permissions denied or not logged in!";
        return Response::returnJson($out);
    }

    public static function addUser() {
        global $_POST, $_ROUTEVAR;
        $out = [
            "done"=>false,
            "errorMessage"=>false,
            "redirect"=>false,
            "lol"=>"ö"
        ];

        $userid = (new UserTable)->select()->where("username", $_POST["user"])->first()["id"];

        if (NewPostController::isMy($_ROUTEVAR[1])) {
            if ((new CourseUserTable)->select("*")->where("user", $userid )->first()["id"] == null ) {
                $db = new CourseUserTable;
                $db->user = $userid;
                $db->course = $_ROUTEVAR[1];
                $db->type = "STUDENT";
                $db->save();
                $out["done"] = true;
            }
        }
        return Response::returnJson($out);
    }

    public static function courseFolder() {
        global $_ROUTEVAR;
        if (self::imInCourse($_ROUTEVAR[1])) {
            $course = self::getCourse($_ROUTEVAR[1]);
            $parent = Folder::addFolderIfNotExists("Course ".$course["name"], $course["user"]);
            $folder = Folder::addFolderIfNotExists("uploads", $course["user"], $parent);
            \view("files/directory",[
                "folder"=>$parent
            ]);
        }
    }

    public static function imInCourse($course) {
        return (new CourseUserTable())
                ->select("*")
                ->where("course", $course)
                ->andwhere("user", USER["id"])
                ->first()["id"] != null;
    }

    public static function getCourse($course) {
        $db = (new \databases\CoursesTable)
                ->select("*")
                ->where("id", $course)
                ->first();
        if ($db["id"] != null) {
            $db["user"] = (new \databases\CourseUserTable)->select("user")->where("course", $db["id"])->first()["user"];
            return $db;
        }

        return false;
    }

}
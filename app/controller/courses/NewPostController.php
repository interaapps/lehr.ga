<?php
namespace app\controller\courses;


use databases\CoursesTable;
use databases\CoursePostsTable;
use databases\CourseUserTable;
use ulole\core\classes\Response;
use ulole\core\classes\util\Str;

class NewPostController {

    public static function newPostPage() {
        global $_ROUTEVAR;
        if (self::isMy($_ROUTEVAR[1]))
            view("courses/newPost", [
                "pageid"=>$_ROUTEVAR[1]
            ]);
        else
            Response::redirect("/");
    }

    public static function newPostHandler() {
        global $_ROUTEVAR,
               $_POST;

        $out = [
            "done"=>false,
            "errorMessage"=>false,
            "redirect"=>false
        ];
        $contents = ["title"=>""];
        if (self::isMy($_ROUTEVAR[1]))
            if (isset($_POST["title"]) && isset($_POST["text"]) && isset($_POST["type"])) {
                if (
                    !Str::contains("<script", $_POST["text"]) &&
                    !Str::contains("<link", $_POST["text"]) &&
                    !Str::contains("<style", $_POST["text"]) && (
                        $_POST["type"] == "WORKSHEAT" ||
                        $_POST["type"] == "IMAGE_WORKSHEAT" ||
                        $_POST["type"] == "POST" )
                ) {
                    $contents["title"] = htmlspecialchars($_POST["title"]);
                    
                    if ($_POST["type"] == "WORKSHEAT" || $_POST["type"] == "POST")
                        $contents["text"]  = $_POST["text"];
                    else
                        $contents["image"] = $_POST["text"];;

                    $db = new CoursePostsTable();
                    $db->user = USER["id"];
                    $db->course = $_ROUTEVAR[1];
                    $db->contents = json_encode($contents);
                    $db->type = $_POST["type"];
                    $db->save();
                    $out["done"] = true;
                    $out["redirect"] = "/course/".$_ROUTEVAR[1]."/post/".$db->getObject()->lastInsertId();
                } else $out["errorMessage"] = "Error";
            } else
                $out["errorMessage"] = "Invalid request";
        else
            $out["errorMessage"] = "Permissions denied!";

        return Response::returnJson($out);
    }

    public static function isMy($courseId) {
        if ((new CoursesTable())->select("*")->where("id", $courseId)->first()["id"] !== null)
            return (new CourseUserTable())->select("*")->where("user", USER["id"])->andwhere("type", "TEACHER")->first()["id"] !== null;
        return false;
    }

}
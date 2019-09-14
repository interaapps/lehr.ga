<?php
namespace app\controller\courses;


use databases\CoursesTable;
use databases\CourseUserTable;
use ulole\core\classes\Response;

class MyCoursesController {

    public static function myCoursesPage() {
        \view("courses/myCourses");
    }

    public static function myCoursesHandler() {
        $out = [
            "done"=>false,
            "errorMessage"=>false,
            "redirect"=>false,
            "courses"=>[

            ]
        ];

        $db = (new CourseUserTable)->select("*")->where("user", USER["id"])->get();
        foreach ($db as $obj) {
            $out["done"] = true;
            $userData = (new CoursesTable())->select("*")->where("id", $obj["course"])->first();
            array_push($out["courses"], [
                "id"=>$obj["course"],
                "title"=>$userData["name"],
                "type"=>$obj["type"]
            ]);
        }

        return Response::returnJson($out);
    }

}
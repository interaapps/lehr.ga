<?php
namespace app\controller\files;

use ulole\core\classes\Response;
use app\classes\files\Folder;

class FolderController {

    public static function personalFolderPage() {
        global $_ROUTEVAR;

        \view("files/directory",[
            "folder"=>"m"
        ]);
    }

    public static function folderPage() {
        global $_ROUTEVAR;

        $db = (new \databases\FolderTable)
                ->select("*")
                ->where("user", USER["id"])
                ->andwhere("id", $_ROUTEVAR[1])
                ->first();
        if ($db["id"] != null)
            \view("files/directory",[
                "folder"=>$db["id"]
            ]);
        else
            Response::redirect("/");
    }

    public static function folderHandler() {
        global $_ROUTEVAR;
        $id = $_ROUTEVAR[1];
        $return = [
            "done"=>false,
            "errorMessage"=>false,
            "redirect"=>false,
            "data"=>[]
        ];
        $thisFolder = (new \databases\FolderTable)->select("*")->where("id", $id)->first();
        if ($id == "m") {
            $folder = (new \databases\FolderTable)->select("*")->where("parent", "0")->andwhere("user", USER["id"])->get();
            $files  = (new \databases\FilesTable)->select("*")->where("folder", "0")->andwhere("user", USER["id"])->get();
        } else {
            $folder = (new \databases\FolderTable)->select("*")->where("parent", $id)->get();
            $files  = (new \databases\FilesTable)->select("*")->where("folder", $id)->get();
        }

        foreach ($folder as $obj) {
            array_push($return["data"], [
                "type"=>"folder",
                "name"=>$obj["name"],
                "link"=>"/folder/".$obj["id"],
                "id"=>$obj["id"]
            ]);
        }

        foreach ($files as $obj) {
            array_push($return["data"], [
                "type"=>"file",
                "name"=>$obj["name"],
                "link"=>$obj["file"],
                "id"=>$obj["id"]
            ]);
        }
        $return["done"] = true;
        return Response::returnJson($return);
    }

    public static function moveFile() {
        global $_POST;
        $out = [
            "done"=>false,
            "errorMessage"=>false,
            "redirect"=>false
        ];
        if ((new \databases\FolderTable)
            ->select("*")
            ->where("user", USER["id"])
            ->andwhere("id", $_POST["folder"])
            ->first()["id"] != null 
            || (new \databases\FilesTable)
            ->select("*")
            ->where("user", USER["id"])
            ->andwhere("id", $_POST["file"])
            ->first()["id"] != null
        ) {
           (new \databases\FilesTable)
                ->update()
                ->set("folder", $_POST["folder"])
                ->where("user", USER["id"])
                ->andwhere("id", $_POST["file"])->run();
            $out["done"] = true;
        }
        return Response::returnJson($out);
    }   

    public static function newFolder() {
        Folder::addFolder($_POST["name"], USER["id"], $_POST["folder"]);
        return '{"done": true}';
    }
}
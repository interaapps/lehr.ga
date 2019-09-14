<?php
namespace app\classes\files;

class Folder {

    public static function addFolder($name, $user, $in=0) {
        if ($in=="m") $in = 0;
        if (!self::imInFolder($in))
            return false;
        $db = new \databases\FolderTable;
        $db->user = $user;
        $db->parent = $in;
        $db->name = $name;
        $db->save();
        return $db->getObject()->lastInsertId();
    }

    public static function addFolderIfNotExists($name, $user, $in=0) {
        if (!self::imInFolder($in))
            return false;
        $db = (new \databases\FolderTable)->select("*")
                    ->where("name", $name)
                    ->andwhere("parent", $in)
                    ->first();
        if ($db["id"] == null)
            return self::addFolder($name, $user, $in);
        else 
            return $db["id"];
        return false;
    }

    public static function imInFolder($folder) {
        return (new \databases\FolderTable)->select("*")
            ->where("id", $folder)
            ->andwhere("user", USER["id"])
            ->first()["id"] != null
            || $folder == 0;
    }

}
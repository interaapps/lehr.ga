<?php
namespace app\controller\files;


use ulole\core\classes\util\Str;

class FileController {

    public static function get() {
        global $_ROUTEVAR;

        if (Str::contains("..", $_ROUTEVAR[1]))
            return "Unsecure";

        if (file_exists("storage/uploads/".$_ROUTEVAR[1])) {
            header("Content-Type: ".mime_content_type("storage/uploads/".$_ROUTEVAR[1]));
            return readfile("storage/uploads/" . $_ROUTEVAR[1]);
        } else
            return "File not found";


    }

}
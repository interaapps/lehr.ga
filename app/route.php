<?php
/*

"/"          =   Homepage
"@__404__@"  =   Page not found

(Do not use duplicated keys!)

You can use also this syntax for adding pages
$router->get("/test1", "homepage");
*/

// Directory for the views
$views_dir      =  "resources/views/";
$templates_dir  =  "resources/views/templates/";

$route = [
  "@__404__@"  =>     "404.php"
];

$router->group("/auth", function(Router $innerRouter) {
  $innerRouter->get("/login", "user/auth/login.php");
  $innerRouter->get("/register", "");
  $innerRouter->post("/login", "!user\AuthController@loginHandler");
});

$router->post("/lehrga/app/api/version", function() {
    return "1.0";
});

$router->middleware("!\app\middlewares\UserMiddleware@loggedIn", "!user\AuthController@redirectToLogin", function (Router $middlewareRouter) {

    $middlewareRouter->group("/course/([0-9]*)", function( Router $innerRouter) {

        $innerRouter->get("",  "!courses\CourseController@coursePage");
        $innerRouter->post("", "!courses\CourseController@courseHandler");

        $innerRouter->get("/folder",  "!courses\CourseController@courseFolder");

        $innerRouter->post("/people", "!courses\CourseController@peopleHandler");
        $innerRouter->post("/people/add", "!courses\CourseController@addUser");

        $innerRouter->get("/new",  "!courses\NewPostController@newPostPage");
        $innerRouter->post("/new", "!courses\NewPostController@newPostHandler");

        $innerRouter->get("/post/([0-9]*)", "!courses\PostController@postPage");
        $innerRouter->post("/post/([0-9]*)", "!courses\PostController@postHandler");
        $innerRouter->post("/post/([0-9a]*)/delete", "!courses\PostController@deletePost");


        $innerRouter->post("/post/([0-9]*)/submit:work", "!courses\WorksheatController@submitWorksheat");
        $innerRouter->get("/post/([0-9]*)/submits", "!courses\WorksheatController@submitsPage");
        $innerRouter->post("/post/([0-9]*)/submits", "!courses\WorksheatController@submitsHandler");

        $innerRouter->post("/post/([0-9]*)/submit:imageworksheat", "!courses\ImageWorksheatController@imageSubmit");
        $innerRouter->post("/post/([0-9]*)/submits:image", "!courses\ImageWorksheatController@submitsHandler");

    });

    $middlewareRouter->get("/", "homepage.php");

    $middlewareRouter->get("/courses", "!courses\MyCoursesController@myCoursesPage");
    $middlewareRouter->post("/courses", "!courses\MyCoursesController@myCoursesHandler");

    $middlewareRouter->post("/course/new", "!courses\CourseController@newCourse");

    $middlewareRouter->get("/auth/myaccount", "/user/myAccount.php");
    $middlewareRouter->post("/auth/myaccount", "!user\MyAccountController@myAccountHandler");

    $middlewareRouter->post("/fileupload:img", "!files\FileUploadController@images");
    $middlewareRouter->post("/fileupload:file", "!files\FileUploadController@file");

    $middlewareRouter->get("/file/(.*)", "!files\FileController@get");

    $middlewareRouter->get("/storage", "!files\FolderController@personalFolderPage");
    $middlewareRouter->get("/folder/([0-9a-z]*)", "!files\FolderController@folderPage");
    $middlewareRouter->post("/folder/([0-9a-z]*)", "!files\FolderController@folderHandler");

    $middlewareRouter->post("/move/file", "!files\FolderController@moveFile");
    $middlewareRouter->post("/move/folder", "!files\FolderController@moveFolder");

    $middlewareRouter->post("/new/folder", "!files\FolderController@newFolder");
});

$router->middleware("!\app\middlewares\UserMiddleware@isTeacherOrAdmin", function () { \ulole\core\classes\Response::redirect("/"); }, function (Router $middlewareRouter) {
    //$middlewareRouter->get("/user", "");
    $middlewareRouter->get("/course/add", "homepage.php");
    $middlewareRouter->post("/user/search", "!user\UserUtilsController@search");
});

$router->get("/autocomplete", "autocomplete.php");

$router->get("/messages", "chats/chats.php");
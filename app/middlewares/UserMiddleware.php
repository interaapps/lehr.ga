<?php
namespace app\middlewares;

class UserMiddleware {

    public static function loggedIn() {
        return USER !== false;
    }

    public static function isAdmin() {
        return USER["type"] == "ADMIN";
    }

    public static function isTeacher() {
        return USER["type"] == "TEACHER";
    }

    public static function isTeacherOrAdmin() {
        return USER["type"] == "TEACHER" || USER["type"] == "ADMIN";
    }

    public static function isStudent() {
        return USER["type"] == "STUDENT";
    }

}

<?php
require "ulole/CLI/Custom.php";
require "ulole/core/Init.php";
/*
    Here you can register functions for the ULOLE CLI!
    Executing: php ulole run <myFunction> (Here are your arguments (Starting with 3))
*/

$CLI = new Custom();

$CLI->showArgsOnError = false;


$CLI->register("newuser", function($args) {
    if (count($args) == 6)
        app\classes\user\User::register($args[3], $args[4], $args[5]);
    return "Added\n";
});

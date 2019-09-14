<?php
namespace app\classes\utils;

use \ulole\core\classes\util\secure\Hash;

class Security {

    public static function hashPassword(string $string) {
        return Hash::sha512(Hash::sha1($string).Hash::sha512($string).Hash::sha1($string));
    }

}
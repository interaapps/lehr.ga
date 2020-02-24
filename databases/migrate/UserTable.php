<?php
namespace databases\migrate;

use modules\uloleorm\migrate\Migrate;

class UserTable extends Migrate {
    public function database() {
        $this->create('user', function($table) {
            $table->int("id")->ai();
            $table->string("username");
            $table->string("password", 128);
            $table->string("profileimage");
            $table->enum("type", ["ADMIN", "TEACHER", "STUDENT"]);
        });
    }
}

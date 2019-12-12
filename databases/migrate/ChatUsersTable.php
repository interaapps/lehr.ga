<?php
namespace databases\migrate;

use modules\uloleorm\migrate\Migrate;

class ChatUsersTable extends Migrate {
    public function database() {
        $this->create('chat_users', function($table) {
            $table->int("id")->ai();
            $table->int("chat_id");
            $table->int("user_id");
            $table->enum("role", [
                "MEMBER",
                "ADMIN"
            ]);
            $table->timestamp("created")->currentTimestamp();
        });
    }
}

<?php
namespace databases\migrate;

use modules\uloleorm\migrate\Migrate;

class MessagesTable extends Migrate {
    public function database() {
        $this->create('messages', function($table) {
            $table->int("id")->ai();
            $table->string("user_id");
            $table->string("contents");
            $table->string("extra");
            $table->timestamp("created")->currentTimestamp();
        });
    }
}

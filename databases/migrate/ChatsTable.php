<?php
namespace databases\migrate;

use modules\uloleorm\migrate\Migrate;

class ChatsTable extends Migrate {

    public function database() {
        $this->create('chats', function($table) {
            $table->int("id")->ai();
            $table->string("name");
            $table->string("settings");
            $table->enum("type", [
                "PRIVATE",
                "GROUP"
            ]);          
            $table->timestamp("created")->currentTimestamp();
        });
    }

}

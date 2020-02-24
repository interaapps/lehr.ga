<?php
namespace databases\migrate;

use modules\uloleorm\migrate\Migrate;

class FolderTable extends Migrate {
    public function database() {
        $this->create('folder', function($table) {
            $table->int("id")->ai();
            $table->int("user");
            $table->string("name");
            $table->int("parent");
            $table->enum("type", ["NORMAL", "COURSEDIRECTORY"]);
            $table->timestamp("created")->currentTimestamp();
        });
    }
}

<?php
namespace databases\migrate;

use modules\uloleorm\migrate\Migrate;

class FilesTable extends Migrate {
    public function database() {
        $this->create('files', function($table) {
            $table->int("id")->ai();
            $table->int("user");
            $table->string("name");
            $table->string("file");
            $table->int("folder")->default(0);
            $table->timestamp("created")->currentTimestamp();
        });
    }
}

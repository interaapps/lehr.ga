<?php
namespace databases\migrate;

use modules\uloleorm\migrate\Migrate;

class WorksheatSubmitsTable extends Migrate {
    public function database() {
        $this->create('worksheat_submits', function($table) {
            $table->int("id")->ai();
            $table->int("worksheat");
            $table->int("user");
            $table->text("contents");
            $table->timestamp("created")->currentTimestamp();
        });
    }
}

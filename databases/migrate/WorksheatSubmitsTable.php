<?php
namespace databases\migrate;

use ulole\modules\ORM\migrate\Migrate;
use ulole\modules\ORM\migrate\MigrationObjects;

class WorksheatSubmitsTable extends Migrate {
    public function database() {
        $this->create('worksheat_submits', function(MigrationObjects $table) {
            $table->int("id")->ai();
            $table->int("worksheat");
            $table->int("user");
            $table->text("contents");
            $table->timestamp("created")->currentTimestamp();
        });
    }
}

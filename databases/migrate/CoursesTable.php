<?php
namespace databases\migrate;

use ulole\modules\ORM\migrate\Migrate;
use ulole\modules\ORM\migrate\MigrationObjects;

class CoursesTable extends Migrate {
    public function database() {
        $this->create('courses', function(MigrationObjects $table) {
            $table->int("id")->ai();
            $table->string("name");
            $table->timestamp("created")->currentTimestamp();
        });
    }
}

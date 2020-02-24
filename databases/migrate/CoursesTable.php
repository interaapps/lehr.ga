<?php
namespace databases\migrate;

use modules\uloleorm\migrate\Migrate;

class CoursesTable extends Migrate {
    public function database() {
        $this->create('courses', function($table) {
            $table->int("id")->ai();
            $table->string("name");
            $table->timestamp("created")->currentTimestamp();
        });
    }
}

<?php
namespace databases\migrate;

use modules\uloleorm\migrate\Migrate;

class CourseUserTable extends Migrate {
    public function database() {
        $this->create('course_user', function($table) {
            $table->int("id")->ai();
            $table->int("course");
            $table->int("user");
            $table->enum("type", ["STUDENT","TEACHER"]);
            $table->timestamp("created")->currentTimestamp();
        });
    }
}

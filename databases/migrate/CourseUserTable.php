<?php
namespace databases\migrate;

use ulole\modules\ORM\migrate\Migrate;
use ulole\modules\ORM\migrate\MigrationObjects;

class CourseUserTable extends Migrate {
    public function database() {
        $this->create('course_user', function(MigrationObjects $table) {
            $table->int("id")->ai();
            $table->int("course");
            $table->int("user");
            $table->enum("type", ["STUDENT","TEACHER"]);
            $table->timestamp("created")->currentTimestamp();
        });
    }
}

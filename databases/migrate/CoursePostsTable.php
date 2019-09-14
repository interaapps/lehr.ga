<?php
namespace databases\migrate;

use ulole\modules\ORM\migrate\Migrate;
use ulole\modules\ORM\migrate\MigrationObjects;

class CoursePostsTable extends Migrate {
    public function database() {
        $this->create('course_posts', function(MigrationObjects $table) {
            $table->int("id")->ai();
            $table->int("user");
            $table->int("course");
            $table->string("contents");
            $table->enum("type", ["POST","WORKSHEAT", "IMAGE_WORKSHEAT"]);
            $table->timestamp("created")->currentTimestamp();
        });
    }
}

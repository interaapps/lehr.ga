<?php
namespace databases\migrate;

use modules\uloleorm\migrate\Migrate;

class CoursePostsTable extends Migrate {
    public function database() {
        $this->create('course_posts', function($table) {
            $table->int("id")->ai();
            $table->int("user");
            $table->int("course");
            $table->string("contents");
            $table->enum("type", ["POST","WORKSHEAT", "IMAGE_WORKSHEAT"]);
            $table->timestamp("created")->currentTimestamp();
        });
    }
}

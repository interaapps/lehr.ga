<?php
namespace databases;

use modules\uloleorm\Table;
class CoursePostsTable extends Table {

    public $id,
           $user,
           $course,
           $contents,
           $type,
           $created;
    
    public function database() {
        $this->_table_name_ = "course_posts";
        // The __database__ default value is "main"
        $this->__database__ = "main";
    }

}

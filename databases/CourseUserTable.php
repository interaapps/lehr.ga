<?php
namespace databases;

use modules\uloleorm\Table;
class CourseUserTable extends Table {

    public $id,
           $course,
           $user,
           $type,
           $created;
    
    public function database() {
        $this->_table_name_ = "course_user";
        // The __database__ default value is "main"
        $this->__database__ = "main";
    }

}

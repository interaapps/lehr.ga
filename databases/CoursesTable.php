<?php
namespace databases;

use modules\uloleorm\Table;
class CoursesTable extends Table {

    public $id,
           $name,
           $created;
    
    public function database() {
        $this->_table_name_ = "courses";
        $this->__database__ = "main";
    }

}

<?php
namespace databases;

use ulole\modules\ORM\Table;
class CoursesTable extends Table {

    public $id,
           $name,
           $created;
    
    public function database() {
        $this->_table_name_ = "courses";
        $this->__database__ = "main";
    }

}

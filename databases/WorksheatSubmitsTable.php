<?php
namespace databases;

use modules\uloleorm\Table;
class WorksheatSubmitsTable extends Table {

    public $id,
           $worksheat,
           $user,
           $contents,
           $created;
    
    public function database() {
        $this->_table_name_ = "worksheat_submits";
        // The __database__ default value is "main"
        $this->__database__ = "main";
    }

}

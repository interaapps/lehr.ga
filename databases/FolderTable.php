<?php
namespace databases;

use modules\uloleorm\Table;
class FolderTable extends Table {

    public $id, 
           $user,
           $name,
           $type,
           $parent,
           $created;
    
    public function database() {
        $this->_table_name_ = "folder";
        $this->__database__ = "main";
    }

}

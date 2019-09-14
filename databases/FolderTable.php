<?php
namespace databases;

use ulole\modules\ORM\Table;
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

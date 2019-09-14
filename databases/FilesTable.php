<?php
namespace databases;

use ulole\modules\ORM\Table;
class FilesTable extends Table {

    public $id,  
           $user,
           $name,
           $file,
           $curent;
    
    public function database() {
        $this->_table_name_ = "files";
        $this->__database__ = "main";
    }

}

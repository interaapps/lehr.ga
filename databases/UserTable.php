<?php
namespace databases;

use ulole\modules\ORM\Table;
class UserTable extends Table {

    public $id, // INSERT YOUR ROWS IN HERE 
           $username,
           $password,
           $profileimage,
           $type;
    
    public function database() {
        $this->_table_name_ = "user";
        // The __database__ default value is "main"
        $this->__database__ = "main";
    }

}

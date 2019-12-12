<?php
namespace databases;

use modules\uloleorm\Table;
class MessagesTable extends Table {

    public $id,
           $user_id,
           $content, 
           $extra,
           $created;
    
    public function database() {
        $this->_table_name_ = "messages";
        $this->__database__ = "main";
    }

}

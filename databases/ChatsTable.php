<?php
namespace databases;

use modules\uloleorm\Table;
class ChatsTable extends Table {

    public $id, 
           $name,
           $settings,
           $created;

    public function database() {
        $this->_table_name_ = "chats";
        $this->__database__ = "main";
    }

}

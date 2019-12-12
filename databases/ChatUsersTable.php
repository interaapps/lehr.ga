<?php
namespace databases;

use modules\uloleorm\Table;
class ChatUsersTable extends Table {

    public $id, 
           $chat_id,
           $user_id,
           $created;
    
    public function database() {
        $this->_table_name_ = "chat_users";
        $this->__database__ = "main";
    }

}

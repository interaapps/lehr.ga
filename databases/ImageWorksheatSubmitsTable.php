<?php
namespace databases;

use ulole\modules\ORM\Table;
class ImageWorksheatSubmitsTable extends Table {

    public $id,
           $post,
           $user,
           $image,
           $created;
    
    public function database() {
        $this->_table_name_ = "image_worksheat_submits";
        $this->__database__ = "main";
    }

}

<?php
namespace databases\migrate;

use ulole\modules\ORM\migrate\Migrate;

class ImageWorksheatSubmitsTable extends Migrate {
    public function database() {
        $this->create('image_worksheat_submits', function($table) {
            $table->int("id")->ai();
            $table->int("post");
            $table->int("user");
            $table->text("image");
            $table->timestamp("created")->currentTimestamp();
        });
    }
}

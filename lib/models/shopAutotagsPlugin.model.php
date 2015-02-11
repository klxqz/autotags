<?php

class shopAutotagsPluginModel extends waModel {

    protected $table = 'shop_autotags';

    public function truncate() {
        $sql = 'TRUNCATE TABLE `' . $this->table . '`';
        $this->query($sql);
    }

}

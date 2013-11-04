<?php

class shopAutotagsModel extends waModel
{
    protected $table = 'shop_autotags';
    
    
    public function getAll($key = null, $normalize = false)
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->query($sql)->fetchAll($key, $normalize);
    }    
}

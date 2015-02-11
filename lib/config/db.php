<?php

return array(
    'shop_autotags' => array(
        'id' => array('int', 11, 'null' => 0, 'autoincrement' => 1),
        'domain' => array('varchar', 255, 'null' => 0, 'default' => ''),
        'type' => array('varchar', 255, 'null' => 0, 'default' => ''),
        'meta_title' => array('varchar', 255, 'null' => 0, 'default' => ''),
        'meta_keywords' => array('varchar', 255, 'null' => 0, 'default' => ''),
        'meta_description' => array('text', 'null' => 0),
        ':keys' => array(
            'PRIMARY' => array('id'),
            'domain' => 'domain',
            'type' => 'type',
        ),
    ),
);

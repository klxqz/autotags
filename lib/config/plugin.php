<?php

return array(
    'name' => 'Автотеги',
    'description' => 'Автоматическое заполнение мета-тегов',
    'vendor'=>903438,
    'version'=>'1.0.1',
    'img'=>'img/autotags.png',
    'shop_settings' => true,
    'frontend'    => true,
    'icons'=>array(
        16=>'img/autotags.png',
    ),
    'handlers' => array(
        'frontend_product' => 'frontendProduct',
        'frontend_category' => 'frontendCategory',
    ),

);
//EOF

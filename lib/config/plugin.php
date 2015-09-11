<?php

return array(
    'name' => 'Автотеги',
    'description' => 'Автоматическое заполнение мета-тегов',
    'vendor' => '985310',
    'version' => '2.0.3',
    'img' => 'img/autotags.png',
    'shop_settings' => true,
    'frontend' => true,
    'handlers' => array(
        'frontend_product' => 'frontendProduct',
        'frontend_category' => 'frontendCategory',
    ),
);
//EOF

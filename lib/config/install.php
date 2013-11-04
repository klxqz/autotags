<?php
$plugin_id = array('shop', 'autotags');
$app_settings_model = new waAppSettingsModel();
$app_settings_model->set($plugin_id, 'status', '1');
$app_settings_model->set($plugin_id, 'apply_templates', '0');
$app_settings_model->set($plugin_id, 'product_meta_title', '{product_name}');
$app_settings_model->set($plugin_id, 'product_meta_keywords', '{product_name}');
$app_settings_model->set($plugin_id, 'product_meta_description', '{product_summary}');
$app_settings_model->set($plugin_id, 'category_meta_title', '{category_name}');
$app_settings_model->set($plugin_id, 'category_meta_keywords', '{category_name}');
$app_settings_model->set($plugin_id, 'category_meta_description', '');

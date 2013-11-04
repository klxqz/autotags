<?php
$plugin_id = array('shop', 'autotags');
$app_settings_model = new waAppSettingsModel();
$app_settings_model->set($plugin_id, 'status', '1');
$app_settings_model->set($plugin_id, 'apply_templates', '0');
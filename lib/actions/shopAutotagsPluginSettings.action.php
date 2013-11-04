<?php

class shopAutotagsPluginSettingsAction extends waViewAction
{
    public function execute()
    {
        $app_settings_model = new waAppSettingsModel();
        $vals = $app_settings_model->get(array('shop', 'autotags'));
        $this->view->assign('vals', $vals);
    }
}

<?php

class shopAutotagsPluginSettingsAction extends waViewAction
{
    public function execute()
    {
        $app_settings_model = new waAppSettingsModel();
        $settings = $app_settings_model->get(array('shop', 'autotags'));
        
        $routing = wa()->getRouting();
        $domains = $routing->getDomains();
        
        $autotags_model = new shopAutotagsPluginModel();
        $result = $autotags_model->getAll();
        $meta_tags = array();
		foreach($domains as $domain) {
                $meta_tags[$domain] = array('product'=>null,'category'=>null);
        }
        if($result) {
            foreach($result as $item) {
                $domain = $item['domain'];
                $type = $item['type'];
                $meta_tags[$domain][$type] = $item;
            }
        }       
        
        $this->view->assign('domains', $domains);
        $this->view->assign('settings', $settings);
        $this->view->assign('meta_tags', $meta_tags);
        
    }
}

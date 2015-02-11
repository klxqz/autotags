<?php

class shopAutotagsPluginSettingsAction extends waViewAction {

    public function execute() {
        $app_settings_model = new waAppSettingsModel();
        $settings = $app_settings_model->get(array('shop', 'autotags'));

        $routing = wa()->getRouting();
        $domain_routes = $routing->getByApp('shop');
        
        $autotags_model = new shopAutotagsPluginModel();
        $result = $autotags_model->getAll();
        $meta_tags = array();
        foreach ($domain_routes as $domain => $routes) {
            foreach ($routes as $route) {
                if (empty($route['private'])) {
                    $route_url = $domain . '/' . $route['url'];
                    $meta_tags[$route_url] = array('product' => null, 'category' => null);
                }
            }
        }
        
        
        if ($result) {
            foreach ($result as $item) {
                $domain = $item['domain'];
                $type = $item['type'];
                $meta_tags[$domain][$type] = $item;
            }
        }

        $this->view->assign('settings', $settings);
        $this->view->assign('meta_tags', $meta_tags);
    }

}

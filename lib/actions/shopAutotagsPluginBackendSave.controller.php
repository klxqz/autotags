<?php

class shopAutotagsPluginBackendSaveController extends waJsonController 
{
    
    public function execute()
    {
        try {
            
            $shop_autotags = waRequest::post('shop_autotags');
            $meta_tags = waRequest::post('meta_tags');
            
            
            $app_settings_model = new waAppSettingsModel();
            foreach($shop_autotags as $name => $value) {
                $app_settings_model->set(array('shop', 'autotags'), $name, $value);
            }
            
            $autotags_model = new shopAutotagsModel();
            foreach($meta_tags as $domain => $type_tags) {
                foreach($type_tags as $type => $meta_tags) {
                    $data = array('domain'=>$domain, 'type'=>$type);
                    $data['meta_title'] = $meta_tags['meta_title'];
                    $data['meta_keywords'] = $meta_tags['meta_keywords'];
                    $data['meta_description'] = $meta_tags['meta_description'];
                    
                    $autotag = $autotags_model->getByField(array('domain'=>$domain, 'type'=>$type));
                    if($autotag) {
                        $autotags_model->updateById($autotag['id'], $data);
                    } else {
                        $autotags_model->insert($data);
                    }
                    
                }
            }


            $this->response['message'] = "Сохранено";
        } catch (Exception $e) {
            $this->setError($e->getMessage());
        }
    }
}
<?php

class shopAutotagsPlugin extends shopPlugin {

    public function frontendProduct($product) {

        $this->replaceTpl('product', $product);
    }

    public function frontendCategory($category) {
        $this->replaceTpl('category', $category);
    }

    protected function replaceTpl($type, $item) {
        if (!$this->getSettings('status')) {
            return false;
        }

        $domain = wa()->getRouting()->getDomain(null, true);
        $route = wa()->getRouteUrl('shop/frontend');
        $domain_route = $domain . $route . '*';

        $meta_tags = array('meta_title', 'meta_keywords', 'meta_description');
        $apply_templates = $this->getSettings('apply_templates');

        $autotags_model = new shopAutotagsPluginModel();
        $autotags = $autotags_model->getByField(array('domain' => $domain_route, 'type' => $type));

        $vals = array();
        foreach ($meta_tags as $meta_tag) {
            $tpl = $autotags[$meta_tag];
            $vals[$meta_tag] = $this->{$type . 'ReplaceTpl'}($tpl, $item, $meta_tag, $type, $domain_route);
        }

        if ($vals['meta_title'] && (!$item['meta_title'] || $apply_templates)) {
            wa()->getResponse()->setTitle($vals['meta_title']);
        }

        if ($vals['meta_keywords'] && (!$item['meta_keywords'] || $apply_templates)) {
            wa()->getResponse()->setMeta('keywords', $vals['meta_keywords']);
        }

        if ($vals['meta_description'] && (!$item['meta_description'] || $apply_templates)) {
            wa()->getResponse()->setMeta('description', $vals['meta_description']);
        }
    }

    public function productReplaceTpl($tpl, $product, $meta_tag, $type, $domain) {
        if (!$tpl) {
            return false;
        }
        $filename = md5($domain) . '_' . $type . '_' . $meta_tag . '_' . md5($tpl) . '.html';
        $temp_file = wa()->getCachePath('plugins/autotags/' . waLocale::transliterate($filename, 'en_US'));
        $this->existsTempTpl($temp_file, $tpl);

        $path = $this->getPath($product);

        $category = null;
        if ($product['category_id']) {
            $category_model = new shopCategoryModel();
            $category = $category_model->getById($product['category_id']);
        }

        $sku_id = $product['sku_id'];

        $view = wa()->getView();
        $view->assign('product', $product);
        $view->assign('sku', $product->skus[$sku_id]);
        $view->assign('category', $category);
        $view->assign('path', $path);

        $html = $view->fetch($temp_file);
        return $html;
    }

    public function categoryReplaceTpl($tpl, $category, $meta_tag, $type, $domain) {
        if (!$tpl) {
            return false;
        }
        $filename = md5($domain) . '_' . $type . '_' . $meta_tag . '_' . md5($tpl) . '.html';
        $temp_file = wa()->getCachePath('plugins/autotags/' . waLocale::transliterate($filename, 'en_US'));
        $this->existsTempTpl($temp_file, $tpl);

        $category_model = new shopCategoryModel();
        $path = $category_model->getPath($category['id']);
        $path = array_values($path);
        
        $view = wa()->getView();
        $view->assign('category', $category);
        $view->assign('path', $path);

        $html = $view->fetch($temp_file);
        return $html;
    }

    public function getPath(shopProduct $product) {
        if (!$product['category_id']) {
            return false;
        }
        $category_model = new shopCategoryModel();
        $category = $category_model->getById($product['category_id']);
        $path = $category_model->getPath($category['id']);
        array_unshift($path, $category);
        return $path;
    }

    private function existsTempTpl($temp_file, $tpl) {
        if (!file_exists($temp_file)) {
            if ($f = @fopen($temp_file, 'w+')) {
                fwrite($f, $tpl);
                fclose($f);
            } else {
                throw new waException("Ошибка создания файла " . $temp_file);
            }
        }
    }

}

<?php


class shopAutotagsPlugin extends shopPlugin
{
    public function frontendProduct($product)
    {
        $this->replaceTpl('product',$product);
    }
    
    public function frontendCategory($category)
    {
        $this->replaceTpl('category',$category);
    }
    
    protected function replaceTpl($type,$item)
    {
        if(! $this->getSettings('status')){
            return false;
        }
        
        $domain = wa()->getRouting()->getDomain(null, true);        
        $params = array('meta_title','meta_keywords','meta_description');
        $apply_templates = $this->getSettings('apply_templates');
        
        $autotags_model = new shopAutotagsModel();
        $autotags = $autotags_model->getByField(array('domain'=>$domain, 'type'=>$type));
        
        $vals=array();  
        foreach($params as $param) {
            $tpl = $autotags[$param];
            $vals[$param] = $this->{$type.'ReplaceTpl'}($tpl,$item);
        }

        if($vals['meta_title'] && (!$item['meta_title'] || $apply_templates)) {
                wa()->getResponse()->setTitle($vals['meta_title']);
        }
        
        if($vals['meta_keywords'] && (!$item['meta_keywords'] || $apply_templates)) {
                wa()->getResponse()->setMeta('keywords', $vals['meta_keywords']);
        }
        
        if($vals['meta_description'] && (!$item['meta_description'] || $apply_templates)) {
                wa()->getResponse()->setMeta('description',$vals['meta_description']);
        }
    }
    
    public function productReplaceTpl($tpl,$product)
    {
        $replaces = array('name','summary','description','price','min_price','max_price','compare_price','count');

        foreach($replaces as $replace) {
            $tpl = str_replace('{product_'.$replace.'}',$product[$replace],$tpl);
        }

        $category_model = new shopCategoryModel();
        $category = $category_model->getById($product['category_id']);
        
        $tpl = $this->categoryReplaceTpl($tpl,$category);
        return $tpl;
    }
    
    
    public function categoryReplaceTpl($tpl,$category)
    {
        $replaces = array('name','description');
        
        foreach($replaces as $replace) {
            $tpl = str_replace('{category_'.$replace.'}',$category[$replace],$tpl);
        }  
        return $tpl;
    }
    
    

}


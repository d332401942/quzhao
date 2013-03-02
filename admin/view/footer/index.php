<?php

class IndexFooterView extends BaseView
{
    
    public function index()
    {
        $this->assign('title', '页脚内容');
        $business = new FooterBusiness();
        $models = $business->findTitle();
        $this->assign('models', $models);
    }
}

<?php

class FooterControlView extends BaseView
{

    public function index()
    {
        //得到页脚的类别
        $business = new FooterBusiness();
        $models = $business->findTitle();
        $this->assign('models', $models);
    }
}
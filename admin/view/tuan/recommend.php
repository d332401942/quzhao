<?php

class RecommendTuanView extends BaseView
{
    
    public function Index()
    {
        $this->assign('title', '团购');
        $business = new NetTuanBusiness();
        $models = $business->getRecommend();
        $this->assign('models', $models);
    }
}
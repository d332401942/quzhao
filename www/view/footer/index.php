<?php

class IndexFooterView extends BaseView
{
    
    private $id;
    
    public function Index($parameters)
    {
        if (empty($parameters['id']) || !(int)$parameters['id'])
        {
            throw new ViewExceptionLib('参数错误');
        }
        $id = (int)$parameters['id'];
        $this->id = $id;
        $this->cache('cacheData',$id);
    }
    
    public function cacheData()
    {
        $id = $this->id;
        $business = new FooterBusiness();
        $models = $business->findTitle();
        $detailModel = $business->getOneById($id);
        if (!$detailModel)
        {
            throw new ViewExceptionLib('参数错误');
        }
        $this->assign('detailModel', $detailModel);
        $this->assign('models', $models);
        $this->assign('id', $id);
    }
}
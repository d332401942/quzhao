<?php

class IndexHomebsView extends BaseView
{
    
    public function index()
    {
        $this->cache('cacheData');
    }
    
    public function cacheData()
    {
        $footerBusiness = new FooterBusiness();
        $titleModels = $footerBusiness->findTitle();
        $this->assign('titleModels', $titleModels);
        
        $classBusiness = new HomeBsClassBusiness();
        $dataBusiness = new HomeBsDataBusiness();
        $dataModels = $dataBusiness->findAll();
        $classModels = $classBusiness->findAll();
        
        $array = array();
        foreach ($dataModels as $model)
        {
            $array[$model->bid][] = $model;
        }
        $jsonData = json_encode($array);
        $this->assign('classModels', $classModels);
        $this->assign('jsonData', $jsonData);
    }
}
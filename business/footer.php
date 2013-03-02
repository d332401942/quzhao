<?php

class FooterBusiness extends BaseBusiness
{
    
    public function del($id)
    {
        $data = new FooterData();
        $data->delById($id);
    }
    
    public function updateByModel($model)
    {
        $data = new FooterData();
        $data->updateModel($model);
    }
    
    public function add($model)
    {
        $data = new FooterData();
        $data->add($model);
    }
    
    public function findTitle()
    {
        $data = new FooterData();
        return $data->findTitle();
    }
    
    public function getOneById($id)
    {
        $data = new FooterData();
        return $data->getOneById($id);
    }
}
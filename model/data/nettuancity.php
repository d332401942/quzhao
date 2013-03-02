<?php

class NetTuanCityDataModel extends BaseDataModel
{
    
    public $flag;
    
    public $head;
    
    public $name_cn;
    
    public $name_en;
    
    public $sort;
    
    public function __construct()
    {
        parent::__construct();
        $this->setTableName('net_tuan_city');
    }
}
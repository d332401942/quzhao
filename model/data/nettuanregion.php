<?php 

class NetTuanRegionDataModel extends BaseDataModel
{
    
    public $name_cn;
    
    public $pid;
    
    public $sort;
    
    public function __construct()
    {
        parent::__construct();
        $this->setTableName('net_tuan_region');
    }
}
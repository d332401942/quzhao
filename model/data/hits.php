<?php

class HitsDataModel extends BaseDataModel
{
    
    /**
     * 9.9或超值单品数据
     */
    const TYPE_HOME_DATA = 1; 
	
	
    
    /**
     * 品牌特卖数据
     */
    const TYPE_BRAND = 2;
    
    /**
     * 团购数据
     */
    const TYPE_TUAN = 3;
    
    public $ip;
    
    public $time;
    
    public $data_id;
    
    public $user_id;
    
    public $type;


	public function __construct()
	{
		parent::__construct();
		$this->setTableName('hits');
	}
}

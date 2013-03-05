<?php 

class NetTuanDataDataModel extends BaseDataModel
{
	/**
	 * 
	 * @var unknown_type
	 */
	const ISVALID_YES = 1;
	
	const ISVALID_NO = 0;
    
    public $name;
    
    public $pdt_url;
    
    public $pic_url;
    
    public $ori_price;
    
    public $cur_price;
    
    public $end_time;
    
    public $create_time;
    
    public $bought;
    
    public $rebate;
    
    public $orderrandom;
    
    public $webname;
    
    public $s_city_id;
    
    public $s_region_id;
    
    public $s_class_1;
    
    public $s_class_2;
    
    public $product_category;
    
    public $city_id;
    
    public $region;
    
    public function __construct()
    {
        parent::__construct();
        $this->setTableName('net_tuan_data');        
    }
}
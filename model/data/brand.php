<?php 
class BrandDataModel extends BaseDataModel
{
    public $brand_name_id;
	
	public $userid = 0;
	
	public $url;
	
	public $createtime;
	
	public $username;
	
	public $rebate;
	
	public $audit;
	
	//商品状态  1 已经通过，2无货，3不合格，4待审核，5已经删除
	public $state = 4;
	
	public $merchantsId;
	
	public $istj = 0;
	
	public $temp = 0;
	
	public $maxrebate = 0;

	public function __construct()
	{
		parent::__construct();
		$this->setTableName('brand');
		$this->setIgoneFields('colums');
		$this->setIgoneFields('username');
	}
}

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
	
	public $state = 0;
	
	public $merchantsId;

	public function __construct()
	{
		parent::__construct();
		$this->setTableName('brand');
		$this->setIgoneFields('colums');
		$this->setIgoneFields('username');
	}
}

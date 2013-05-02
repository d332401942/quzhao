<?php 
class BrandDataModel extends BaseDataModel
{
    public $name;
	
    public $letter;
	
	public $cate;
	
	public $image;
	
	public $userid;
	
	public $url;
	
	public $createtime;
	
	public $cateName;
	
	public $username;
	
	public $rebate;
	
	public $merchantsId;
	
	public $colums = array();

	public function __construct()
	{
		parent::__construct();
		$this->setTableName('brand');
		$this->setIgoneFields('colums');
		$this->setIgoneFields('cateName');
		$this->setIgoneFields('username');
	}
}

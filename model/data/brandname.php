<?php 
class BrandnameDataModel extends BaseDataModel
{
	public $name;
	
	public $image;
	
	public $cateid;

	public $letter;
	
	
	public function __construct()
	{
		parent::__construct();
		$this->setTableName('brand_name');
	}
}

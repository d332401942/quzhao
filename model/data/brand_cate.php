<?php 
class Brand_cateDataModel extends BaseDataModel
{
    public $name;

	public $sort = 0;
	
	public function __construct()
	{
		parent::__construct();
		$this->setTableName('brand_cate');
	}
}

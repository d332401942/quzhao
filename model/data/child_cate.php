<?php 
class Child_cateDataModel extends BaseDataModel
{
    public $name;
	
	public $brand_cate_id;
	
	public function __construct()
	{
		parent::__construct();
		$this->setTableName('child_cate');
	}
}

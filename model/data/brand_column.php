<?php 
class Brand_columnDataModel extends BaseDataModel
{
    public $brandid;
	
    public $cateid;

	public function __construct()
	{
		parent::__construct();
		$this->setTableName('brand_column');
	}
}

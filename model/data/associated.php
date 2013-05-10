<?php

class AssociatedDataModel extends BaseDataModel
{
	public $keyname;
	
	public $categoryids;
	
	public $brandids;
	
	public $price;

	public $isgroup = 0;
	
	
	public function __construct()
	{
		parent::__construct();
		$this->setTableName('s_key');
	}
}

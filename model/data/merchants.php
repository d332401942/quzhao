<?php

class MerchantsDataModel extends BaseDataModel
{
	public $name;
	
	public $sort = 0;
	
	public function __construct()
	{
		parent::__construct();
		$this->setTableName('merchants');
	}
}

<?php

class MerchantsDataModel extends BaseDataModel
{
	public $name;
	
	public function __construct()
	{
		parent::__construct();
		$this->setTableName('merchants');
	}
}

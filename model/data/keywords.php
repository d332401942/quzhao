<?php

class KeywordsDataModel extends BaseDataModel
{
	public $keywords;

	public $createtime;

	public $number;
	
	public $ip;
	
	public function __construct()
	{
		parent::__construct();
		$this->setTableName('keywords');
	}
}

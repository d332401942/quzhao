<?php

class CategoryDataModel extends ModelCoreLib
{

	public $categoryid;
	
	public $attrid;

	public $name;

	public $level;

	public $pid1;

	public $pid2;

	public $sort;

	public $isvalid;

	public $caiji_url;

	public $caiji_memo;
	
	public $children;
	
	public function __construct()
	{
		parent::__construct();
		$this->setPrimaryKey('categoryid');
		$this->setIgoneFields('children');
	}
}

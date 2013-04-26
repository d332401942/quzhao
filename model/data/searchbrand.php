<?php 

class SearchBrandDataModel extends ModelCoreLib
{
	
	public $brandid;
	
	public $brandname;
	
	public $num;
	
	public function __construct()
	{
		parent::__construct();
		$this->setPrimaryKey('brandid');
		$this->setIgoneFields('num');
		$this->setTableName('brand');
	}
}
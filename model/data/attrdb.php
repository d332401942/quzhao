<?php

class AttrdbDataModel extends ModelCoreLib
{

	public $attrdbid;
	
	public $attrid;

	public $stype;

	public $name;

	public $info;

	public $sort;

	public $attr;

	public $isvalid;
	
	public $extend;
	
	public function __construct()
	{
		parent::__construct();
		$this->setPrimaryKey('attrdbid');
		$this->setIgoneFields('extend');
	}
}

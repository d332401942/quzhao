<?php

class ShareDataModel extends BaseDataModel
{

	public $uid;
	
	public $url;
	
	public $title;

	public $image;

	public $createtime;
	
	public $content;
	
	public $origin;
	
	public function __construct()
	{
		parent::__construct();
		$this->setTableName('share');
	}
}

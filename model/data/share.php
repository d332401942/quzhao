<?php

class ShareDataModel extends BaseDataModel
{
	const SHARE_STATUS_DEFAULT = 0;
	
	const SHARE_STATUS_OK = 1;
	
	const SHARE_STATUS_DELETE = 2;

	public $userid;
	
	public $url;
	
	public $title;
	
	public $price;

	public $image;

	public $createtime;
	
	public $content;
	
	public $origin;
	
	public $status = self::SHARE_STATUS_DEFAULT;
	
	public function __construct()
	{
		parent::__construct();
		$this->setTableName('share');
	}
}

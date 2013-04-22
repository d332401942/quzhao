<?php

class ReplyDataModel extends BaseDataModel
{
	
	public $userid;

	public $messageid;

	public $content;
	
	public $createtime;
	
	public $status = 0;
	
	public function __construct()
	{
		parent::__construct();
		$this->setTableName('reply');
	}
}

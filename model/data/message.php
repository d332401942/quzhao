<?php

class MessageDataModel extends BaseDataModel
{
	
	public $userid;

	public $pid;

	public $creattime;
	
	public $message;
	
	public $storey;
	
	public function __construct()
	{
		parent::__construct();
		$this->setTableName('message');
	}
}

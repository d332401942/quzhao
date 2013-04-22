<?php

class MessageDataModel extends BaseDataModel
{
	
	public $userid;

	public $pid;

	public $creattime;
	
	public $message;
	
	public $storey;
	
	public $replys = array();
	
	public function __construct()
	{
		parent::__construct();
		$this->setIgoneFields('replays');
		$this->setTableName('message');
	}
}

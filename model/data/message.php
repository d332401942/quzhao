<?php

class MessageDataModel extends BaseDataModel
{
	
	public $userid;

	public $pid;

	public $creattime;
	
	public $message;
	
	public $storey;
	
	public $nickname;
	
	public $head;
	
	public $replys = array();
	
	public function __construct()
	{
		parent::__construct();
		$this->setIgoneFields('replys');
		$this->setIgoneFields('head');
		$this->setIgoneFields('nickname');
		$this->setTableName('message');
	}
}

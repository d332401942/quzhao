<?php

class MessageDataModel extends BaseDataModel
{
	
	public $userid;

	public $pid;

	public $creattime;
	
	public $message;
	
	public $storey;
	
<<<<<<< HEAD
=======
	public $revert = '';
	
	public $replys = array();
	
>>>>>>> 5de9a0546b1777b7e41822904a32fd9daad57dad
	public function __construct()
	{
		parent::__construct();
		$this->setIgoneFields('replays');
		$this->setTableName('message');
	}
}

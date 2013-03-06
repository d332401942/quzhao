<?php

class FriendLinkDataModel extends BaseDataModel
{

	public $name;

	public $logo;

	public $href;

	public $sort;

	public function __construct()
	{
		parent::__construct();
		$this->setTableName('friend_link');	
	}
}

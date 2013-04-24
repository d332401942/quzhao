<?php

class LoveDataModel extends BaseDataModel
{
	public $userid;
	
	public $home_tj_data_id;
	
	public $status;
	
	public $loveType = 0;
	
	public function __construct()
	{
		parent::__construct();
		$this->setTableName('love');
	}
}

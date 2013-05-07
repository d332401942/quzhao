<?php

class LoveDataModel extends BaseDataModel
{
	
	/**
	 * 单品的喜欢
	 * @var unknown
	 */
	const LOVE_TYPE_HOME_TJ_DATA = 0;
	
	/**
	 * 搜索的喜欢
	 * @var unknown
	 */
	const LOVE_TYPE_SEARCH = 1;
	
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

<?php

class NetDataSourceDataModel extends BaseDataModel
{
	/**
	 * 是否有前台数据：有
	 */
	const IS_USE_YES = 1;
	
	/**
	 * 是否有前台数据：无
	 */
	const IS_USE_NO = 0;
	
	
	/**
	 * 来源网站名称
	 * @var varchar(200)
	 */
	public $name;
	
	/**
	 * 是否有前台数据;
	 */
	public $isuse;
	
	public function __construct()
	{
		parent::__construct();
		$this->setTableName('net_data_source');
	}
}
<?php 

/**
 * 抓取数据网站
 */

class NetDataSiteDataModel extends BaseDataModel
{
	
	const IS_USE_TYPE_YES = 1;
	
	const IS_USE_TYPE_NO = 0;
	
	/**
	 * 网站名称
	 * @var varchar(200)
	 */
	public $name;
	
	/**
	 * 是否使用
	 */
	public $isuse;
	
	public function __construct()
	{
		parent::__construct();
		$this->setTableName('net_data_site');
	}
}
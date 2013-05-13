<?php 

class UserConnectDataModel extends BaseDataModel
{
	
	/**
	 * 对应用户表id
	 * @var unknown
	 */
	public $userid;
	
	/**
	 * 第三方返回的ID
	 * @var unknown
	 */
	public $openid;
	
	/**
	 * 注册网站与user表常量对应
	 * @var unknown
	 */
	public $sitetype;
	
	public function __construct()
	{
		parent::__construct();
		$this->setTableName('userconnect');
	}
}
<?php

class UserDataModel extends BaseDataModel
{
	
	const REG_DEFAULT 	= 0;
	
	const OTHER_SITE_QQ = 1;
	
	const OTHER_SITE_WEIBO = 2;
	
	const OTHER_SITE_TAOBAO = 3;
	
	const POWER_DEFAULT = 1;
	
	const POWER_SUPER = 2;

	public $email;
	
	public $password;

	public $regtype;
	
	public $openid;

	public $createtime;

	public $ischecked;

	public $point;

	public $inviteid;

	public $otheraccount;

	public $othersite;

	public $head;
	
	public $nickname;
	
	public $city;
	
	public $status;
	
	/**
	 * 用户权限
	 * @var int
	 */
	public $power;
	
	public function __construct()
	{
		parent::__construct();
		$this->setTableName('user');
	}
}

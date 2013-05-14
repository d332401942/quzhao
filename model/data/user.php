<?php

class UserDataModel extends BaseDataModel
{
	
	const REG_DEFAULT 	= 0;
	
	const OTHER_SITE_QQ = 1;
	
	const OTHER_SITE_WEIBO = 2;
	
	const OTHER_SITE_TAOBAO = 3;
	
	const POWER_DEFAULT = 1;
	
	const POWER_SUPER = 2;

	/**
	 * 登录邮箱
	 * @var string
	 */
	public $email;
	
	/**
	 * 密码
	 * @var string
	 */
	public $password;

	/**
	 * 注册类型
	 * @var int
	 */
	public $regtype;
	
	/**
	 * 注册时间
	 * @var int
	 */
	public $createtime;

	/**
	 * 是否验证过邮箱
	 * @var int
	 */
	public $ischecked;

	/**
	 * 积分
	 * @var int
	 */
	public $point;

	/**
	 * 推荐人ID
	 * @var int
	 */
	public $inviteid;

	/**
	 * 绑定其他登录账号
	 * @var string
	 */
	public $otheraccount;

	/**
	 * 绑定其他的站点
	 * @var int
	 */
	public $othersite;

	/**
	 * 头像图片
	 * @var string
	 */
	public $head;
	
	/**
	 * 昵称
	 * @var string
	 */
	public $nickname;
	
	/**
	 * 城市
	 * @var int
	 */
	public $city;
	
	/**
	 * 状态
	 * @var int
	 */
	public $status;
	
	/**
	 * 用户权限
	 * @var int
	 */
	public $power;
	
	/**
	 * 对应到第三方登录账号上
	 * @var unknown
	 */
	public $userconnects = array();
	
	public function __construct()
	{
		parent::__construct();
		$this->setTableName('user');
		$this->setIgoneFields('userconnects');
	}
}

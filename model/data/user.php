<?php

class UserDataModel extends BaseDataModel
{
	
	const REG_DEFAULT 	= 0;
	
	const OTHER_SITE_QQ = 1;
	
	const OTHER_SITE_SINA = 2;
	
	const OTHER_SITE_TAOBAO = 3;

	public $email;
	
	public $password;

	public $regtype;

	public $createtime;

	public $ischecked;

	public $point;

	public $inviteid;

	public $otheraccount;

	public $othersite;

	public $status;
	
}

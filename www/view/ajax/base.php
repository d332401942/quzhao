<?php

class BaseAjaxView extends AjaxCoreLib
{
	
	const USER_INFO_COOKIE_KEY = 'UserInfo';
	
	protected $Host;
	
	protected $CurrentUser;
	
	protected $ServerName;
	
	public function __construct()
	{
		parent::__construct();
		$this->ServerName = $_SERVER['SERVER_NAME'];
		$this->getCookieUserInfo();
		$this->Host = new HostModel();
	}
	
	private function getCookieUserInfo()
	{
		if (empty($_COOKIE[self::USER_INFO_COOKIE_KEY]))
		{
			return null;
		}
		$userArr = json_decode($_COOKIE[self::USER_INFO_COOKIE_KEY], true);
		$userModel = new UserDataModel();
		$userModel->loadArray($userArr);
		$this->CurrentUser = $userModel;
	}
}
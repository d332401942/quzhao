<?php 

class BaseAjaxView extends AjaxCoreLib
{
	
	public function __construct()
	{
		if (empty($_COOKIE['UserInfo']))
		{
			$this->responseError('not login');
		}
		parent::__construct();
	}
}
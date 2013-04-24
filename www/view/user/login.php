<?php 

class LoginUserView extends BaseView
{
	
	public function index()
	{
		$this->setMeta();
		$connectModel = new ConnectModel($this->ServerName ,'http://' .$this->ServerName);
		$this->assign('connectModel', $connectModel);
	}
}
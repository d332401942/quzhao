<?php

class TopUserView extends BaseView
{
	
	public function index()
	{
		$connectModel = new ConnectModel($this->ServerName);
		$this->assign('connectModel', $connectModel);
	}
}
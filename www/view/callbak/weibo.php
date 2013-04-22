<?php 

class WeiboCallbakView extends BaseView
{
	
	public function index()
	{
		$connectModel = new ConnectModel ( $this->ServerName );
		$code = null;
		if (empty ( $_GET ['code'] ))
		{
			$msg = empty ( $_GET ['error_description'] ) ? null : $_GET ['error_description'];
			$errorCode = empty ( $_GET ['error'] ) ? 0 : $_GET ['error'];
			$this->closeWindow ();
		}
		$code = $_GET['code'];
		$taobaoInfo = $connectModel->getTaobaoInfo($code);
	}
}
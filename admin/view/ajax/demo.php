<?php 

class DemoAjaxView extends BaseAjaxView
{
	
	public function demo()
	{
		$id = $_GET['id'];
		$d = new NetDataBusiness();
		$d->demo1($id);
	}
}
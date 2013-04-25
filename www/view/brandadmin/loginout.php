<?php 

class LoginoutBrandadminView extends BaseView
{
	
	public function index()
	{
		setcookie('brand_id','',-1,'/');
		setcookie('brandModel','',-1,'/');
		$this->redirect(APP_URL . '/brandadmin/login');
	}
}
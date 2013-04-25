<?php 

class ListsBrandadminView extends BaseView
{
	
	public function index()
	{
		
		if(empty($_COOKIE['brand_id']) && empty($_COOKIE['brandModel']))
		{
			$this->redirect(APP_URL . '/brandadmin/login');
		}
		$business = M('BrandBusiness');
		$result = $business->getAll();
		$this->assign('model' ,$result);
		
	}
	

}
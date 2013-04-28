<?php 

class ListsBrandadminView extends BaseView
{
	
	public function index()
	{
		
		if(!isset($_COOKIE['brand_id']) || !isset($_COOKIE['brandModel']) || !isset($_COOKIE['brand_name']))
		{
			$this->redirect(APP_URL . '/brandadmin/login');
		}
		$pageCore = new PageCoreLib ();
		$pageCore->pageSize = 10;
		$page = 1;
		if (! empty ( $_GET ['page'] ) && ( int ) $_GET ['page'])
		{
			$page = ( int ) $_GET ['page'];
		}
		$pageCore->currentPage = $page;
		
		$business = M('BrandBusiness');
		$result = $business->getAll($pageCore);
		$this->assign('model' ,$result);
		$this->assign ( 'pageCore', $pageCore );
		
	}
	

}
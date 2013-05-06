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
		//得到所有数据
		$business = M('BrandBusiness');
		$result = $business->getAll($pageCore);
		$userid = null;
		if(!empty($_COOKIE['brand_id']))
		{
			$userid = $_COOKIE['brand_id'];
		}	
		//得到总数
		$count = $business->getAllTotal($userid);
		//得到已经通过审核总数
		$tgCount = $business->tgCount($userid);
		$this->assign('count',$count);
		$this->assign('tgCount',$tgCount);
		$this->assign('model' ,$result);
		$this->assign ( 'pageCore', $pageCore );
		
	}
	

}
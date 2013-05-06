<?php 

class ListsHomeBrandView extends BaseView
{
	
	public function index()
	{
		$pageCore = new PageCoreLib ();
		$pageCore->pageSize = 10;
		$page = 1;
		if (! empty ( $_GET ['page'] ) && ( int ) $_GET ['page'])
		{
			$page = ( int ) $_GET ['page'];
		}
		$state = null;
		if (isset($_GET['state']) && (int)$_GET['state'])
		{
			$state = $_GET['state'];
		}
		$id = null;
		if (!empty($_GET['id']))
		{
			$id = (int)$_GET['id'];
		}
		$pageCore->currentPage = $page;
		//得到所有商品
		$business = M('BrandBusiness');
		$result = $business->getAll3($pageCore,$state,$id);
		
		$userid = null;
		if(!empty($_COOKIE['brand_id']))
		{
			$userid = $_COOKIE['brand_id'];
		}	
		//得到总数
		$count = $business->getAllTotal($userid);
		//得到已经通过审核总数
		$tgCount = $business->tgCount($userid);
		
		
		$this->assign('id',$id);
		$this->assign('count',$count);
		$this->assign('tgCount',$tgCount);
		$this->assign('userid',$userid);
		$this->assign('model' ,$result);
		$this->assign ( 'pageCore', $pageCore );
		$this->assign ( 'title', '品牌列表');
		
	}
	

}
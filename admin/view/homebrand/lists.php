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
		$pageCore->currentPage = $page;
		
		$business = M('BrandBusiness');
		$result = $business->getAll($pageCore);
		$this->assign('model' ,$result);
		$this->assign ( 'pageCore', $pageCore );
		$this->assign ( 'title', '品牌列表');
		
	}
	

}
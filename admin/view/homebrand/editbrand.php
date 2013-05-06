<?php 

class EditbrandHomeBrandView extends BaseView
{
	
	public function index()
	{
		$pageCore = new PageCoreLib();
		$pageCore->pageSize = 10;
		$page = 1;
		if (! empty ( $_GET ['page'] ) && ( int ) $_GET ['page'])
		{
			$page = ( int ) $_GET ['page'];
		}
		$name = null;
		if (! empty ( $_GET ['name'] ))
		{
			$name = trim( $_GET ['name']);
		}
		$pageCore->currentPage = $page;
		$business = M('BrandnameBusiness');
		$model = $business->getAll($pageCore,$name);
		
		$this->assign ( 'pageCore', $pageCore );
		$this->assign ( 'model', $model );
		$this->assign ( 'title', '品牌管理' );
		
	}
	

}
<?php 

class IndexAssociatedView extends BaseView
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
		$business = M('AssociatedBusiness');
		$model = $business->getAll($pageCore,$name);
		
		
		$this->assign ( 'pageCore', $pageCore );
		$this->assign ( 'model', $model );
		$this->assign ( 'title', '关联管理' );
	}
}

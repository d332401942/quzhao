<?php 

class AddAssociatedView extends BaseView
{
    public function index($parameter)
	{
		$lev = isset($parameter['lev'])?(int)$parameter['lev']:'';
		$cateModel = null;
		$pageCore = new PageCoreLib();
		
		if($lev)
		{
			$pageCore = new PageCoreLib();
			$pageCore->pageSize = 10;
			$page = 1;
			if (! empty ( $_GET ['page'] ) && ( int ) $_GET ['page'])
			{
				$page = ( int ) $_GET ['page'];
			}
			$pageCore->currentPage = $page;
			//得到所有分类
			$cateBusiness = M('CategoryBusiness');
			$cateModel = $cateBusiness->getAll($pageCore,$lev);
		}
		
		if($_POST)
		{
			$cateId = isset($_POST['cateId'])?$_POST['cateId']:array();
			$name = trim($_GET['id']);
			$business = M('AssociatedBusiness');
			$model = new AssociatedDataModel();
			$model->categoryids = 1;
			//$business->add($model,$name);
		}
		$this->assign('title', '添加关联分类');
		$this->assign('model', $cateModel);
		$this->assign ('pageCore', $pageCore);
	}
}

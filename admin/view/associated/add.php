<?php 

class AddAssociatedView extends BaseView
{
    public function index($parameter)
	{
		
		$lev = isset($_GET['lev'])?(int)$_GET['lev']:'';
		$name = isset($parameter['name'])?trim($parameter['name']):'';
		$cateModel = null;
		$pageCore = new PageCoreLib();
		$page = null;
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
			$cateId = implode(',',$cateId);
			$name = trim($_POST['name']);
			$business = M('AssociatedBusiness');
			$result = $business->getKeyname($name);
			if($result)
			{
				$model = new AssociatedDataModel();
				$model->categoryids = $result->categoryids.','.$cateId;
				$business->update($model,$name);
			}
		}
		$this->assign('title', '添加关联分类');
		$this->assign('model', $cateModel);
		$this->assign ('pageCore', $pageCore);
		$this->assign ('name', $name);
		$this->assign ('lev', $lev);
		$this->assign ('page', $page);
	}
}

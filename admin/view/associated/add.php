<?php 

class AddAssociatedView extends BaseView
{
    public function index($parameter)
	{
		
		$lev = isset($_GET['lev'])?(int)$_GET['lev']:1;
		$name = isset($parameter['name'])?trim($parameter['name']):'';
		$cateModel = null;
		$pageCore = new PageCoreLib();
		$page = null;
		$business = M('AssociatedBusiness');
		$cateIdModel = $business->getOneCate($name);
		$cateNameModel = array();
		if(!empty($cateIdModel->categoryids))
		{
			/*
			*	得到已经关联的分类
			*/
			$cateBusiness = M('CategoryBusiness');
			$cateNameModel = $cateBusiness->getCateName($cateIdModel->categoryids);
		}
		
		if(!empty($cateIdModel->categoryids))
		{
			$cateIdModel->categoryids = explode(',',$cateIdModel->categoryids);
		}
	
		if($lev)
		{
			$pageCore = new PageCoreLib();
			$pageCore->pageSize = 100;
			$page = 1;
			if (! empty ( $_GET ['page'] ) && ( int ) $_GET ['page'])
			{
				$page = ( int ) $_GET ['page'];
			}
			$pageCore->currentPage = $page;
			//得到所有分类
			$cateBusiness = M('CategoryBusiness');
			$cateModel = $cateBusiness->getAll($pageCore, $lev);
		}
		if($_POST)
		{
			
			$cateId = isset($_POST['cateId'])?$_POST['cateId']:array();
			$cateId = implode(',',$cateId);
			$name = trim($_POST['name']);
			$model = new AssociatedDataModel();
			$model->categoryids = $cateId;
			$business->update($model,$name);
			$this->redirect(APP_URL.'associated/index__name/'.$_COOKIE['temp_name']);
		}
		$this->assign('title', '添加关联分类');
		$this->assign('model', $cateModel);
		$this->assign ('pageCore', $pageCore);
		$this->assign ('name', $name);
		$this->assign ('lev', $lev);
		$this->assign ('page', $page);
		$this->assign ('cateIdModel', $cateIdModel);
		$this->assign ('cateNameModel', $cateNameModel);
	}
}

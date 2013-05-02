<?php 

class ListUserView extends BaseView
{
	
	public function index()
	{
		$this->assign('title', '会员列表');
		$pageCore = new PageCoreLib();
		if (!empty($_GET['page']))
		{
			$pageCore->currentPage = (int)$_GET['page'];
		}
		$business = new UserBusiness();
		$userModels = $business->findAll($pageCore);
		$this->assign('userModels', $userModels);
		$this->assign('pageCore', $pageCore);
	}
}
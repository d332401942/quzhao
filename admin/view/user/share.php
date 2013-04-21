<?php
class ShareUserView extends BaseView
{
	public function index()
	{
		$pageCore = new PageCoreLib();
		$pageCore->pageSize = 10;
		$business = M('ShareBusiness');
		$page = 1;
		if (!empty($_GET['page']) && (int)$_GET['page'])
		{
			$page = (int)$_GET['page'];
		}
		if (!empty($_GET['cid']))
		{
			$cateId = $_GET['cid'];
		}
		$pageCore->currentPage = $page;
		$cateId = null;
		$result = $business->findAll($pageCore,$cateId);
		
		$this->assign('pageCore',$pageCore);
		$this->assign('model',$result);
		$this->assign('title','会员分享');
	}
}
?>
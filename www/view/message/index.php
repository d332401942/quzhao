<?php
class IndexMessageView extends BaseView
{
	public function index()
	{
		$pageCore = new PageCoreLib();
		$pageCore->pageSize = 10;
		$business = M('MessageBusiness');
		$pid = isset($_GET['pid'])?(int)$_GET['pid']:'';
		$page = 1;
		if (!empty($_GET['page']) && (int)$_GET['page'])
		{
			$page = (int)$_GET['page'];
		}
		$isLastPage = empty($_GET['isLastPage']) ? false : true;
		$pageCore->currentPage = $page;
		$result = $business->findAll($pageCore,$pid,$isLastPage);
		$this->assign('model',$result);
		$this->assign('pageCore',$pageCore);
	}
}
?>
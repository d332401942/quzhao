<?php
class ShowMessageView extends BaseView
{
	public function index()
	{
		$pageCore = new PageCoreLib();
		$pageCore->pageSize = 10;
		$business = M('MessageBusiness');
		$page = 1;
		if (!empty($_GET['page']) && (int)$_GET['page'])
		{
			$page = (int)$_GET['page'];
		}
		$pageCore->currentPage = $page;
		$result = $business->findAllMessage($pageCore);
		$this->assign('pageCore',$pageCore);
		$this->assign('model',$result);
		$this->assign('title','评论管理');
	}
}
?>
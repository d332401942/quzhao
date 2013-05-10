<?php

class IndexKeywordsView extends BaseView
{

	public function index()
	{
		$this->assign('title', '关键词统计');
		$time = null;
		if (isset($_POST['time']) && (int)$_POST['time'])
		{
			$time = $_POST['time'];	
		}
	
		$business = M('KeywordsBusiness');
		$pageCore = new PageCoreLib();
		$pageCore->pageSize = 50;
		$page = 1;
		if (!empty($_POST['page']) && (int)$_POST['page'])
		{
			$page = (int)$_POST['page'];
		}
		$pageCore->currentPage = $page;
		$models = $business->getCount($pageCore, $time);
		$this->assign('models', $models);
		$this->assign('pageCore', $pageCore);
		$this->assign('time', $time);
		$this->assign('page', $page);
	}

}

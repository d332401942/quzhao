<?php

class IndexKeywordsView extends BaseView
{

	public function index()
	{
		$this->assign('title', '关键词统计');
		$time = 1;
		if (isset($_POST['time']))
		{
			$time = $_POST['time'];
		}

		$business = M('KeywordsBusiness');
		$pageCore = new PageCoreLib();
		$models = $business->getCount($pageCore, ($time * 24 * 3600));
		$this->assign('models', $models);
		$this->assign('pageCore', $pageCore);
		$this->assign('time', $time);
	}

}

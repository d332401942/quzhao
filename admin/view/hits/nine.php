<?php

class NineHitsView extends BaseView
{

	public function index($parenr)
	{
		$this->assign('title', '9.9点击');
		$time = 1;
		$dataId = null;
		if (isset($_POST['time']))
		{
			$time = $_POST['time'];
		}
		if (!empty($_POST['dataid']))
		{
			$dataId = $_POST['dataid'];
		}
		$cid = 1;
		if (!empty($parenr['cid']))
		{
			$cid = $parenr['cid'];
			$this->assign('title', '超值单品');
		}
		$type = HitsBusiness::TYPE_NINE;
		$business = M('HitsBusiness');
		$pageCore = new PageCoreLib();
		$pageCore->pageSize = 10;
		$page = 1;
		if (!empty($_POST['page']) && (int)$_POST['page'])
		{
			$page = (int)$_POST['page'];
		}
		$pageCore->currentPage = $page;
		$models = $business->getHits($pageCore, $type, ($time * 24 * 3600), $dataId,$cid);
		$this->assign('models', $models);
		$this->assign('pageCore', $pageCore);
		$this->assign('time', $time);
		$this->assign('dataId', $dataId);
	}

}

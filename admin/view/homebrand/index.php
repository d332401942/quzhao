<?php

class IndexHomeBrandView extends BaseView
{

	public function index()
	{
		$business = new HomeBrandBusiness();
		$pageCore = new PageCoreLib();
		$pageCore->pageSize = 10;
		if (! empty($_GET['page']) && (int)$_GET['page'])
		{
			$pageCore->currentPage = (int)$_GET['page'];
		}
		$ishot = null;
		if (isset($_GET['ishot']) && $_GET['ishot'] != '不限')
		{
			$ishot = (int)$_GET['ishot'];
		}
		$name = null;
		if (! empty($_GET['name']))
		{
			$name = trim($_GET['name']);
		}
		$models = $business->findAll($pageCore, $ishot, $name);
		$models = $models ? $models : array();
		$this->assign('title', '品牌列表');
		$this->assign('models', $models);
		$this->assign('pageCore', $pageCore);
		$this->assign('ishot', $ishot);
		$this->assign('name', $name);
	}
}
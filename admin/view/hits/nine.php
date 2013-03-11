<?php

class NineHitsView extends BaseView
{

	public function index()
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
		$type = HitsBusiness::TYPE_NINE;
		$business = M('HitsBusiness');
		$pageCore = new PageCoreLib();
		$models = $business->getHits($pageCore, $type, ($time * 24 * 3600), $dataId);
		$this->assign('models', $models);
		$this->assign('pageCore', $pageCore);
		$this->assign('time', $time);
		$this->assign('dataId', $dataId);
	}

}

<?php

class IndexDpView extends BaseView
{

	public function Index($parameters)
	{
		$this->setMeta();
		// 得到超值单品的数据
		$business = new HomeTjDataBusiness();
        $pageCore = new PageCoreLib();
        $pageCore->currentPage = !empty($parameters['page']) ? (int)$parameters['page'] : 1;
        $pageCore->currentPage = $pageCore->currentPage ? $pageCore->currentPage : 1;
        $pageCore->pageSize = 16;
		$models = $business->getDp($pageCore);
		//得到推荐的单品
		$tjModels = $business->getTjDpModels(5);
		//得到历史记录
		$dpBrowseHistoryModels = $this->dpBrowseHistoryModels();
		$this->assign('models', $models);
		$this->assign('tjModels', $tjModels);
		$this->assign('dpBrowseHistoryModels', $dpBrowseHistoryModels);
        $this->assign('pageCore',$pageCore);
	}
	
	private function dpBrowseHistoryModels()
	{
		if (empty($_COOKIE['dpBrowseLog']))
		{
			return array();
		}
		$ids = $_COOKIE['dpBrowseLog'];
		$arrIds = explode(',',$ids);
		$business = new HomeTjDataBusiness();
		$models = $business->dpBrowseHistoryModels($arrIds);
		$models = $models ? $models : array();
		return $models;
	}
}
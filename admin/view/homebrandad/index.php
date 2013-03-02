<?php 

/**
 * 广告列表
 */
class IndexHomebrandadView extends BaseView
{
	
	public function index()
	{
		$business = new HomeBrandAdBusiness();
		$pageCore = new PageCoreLib();
		$pageCore->pageSize = 10;
		$models = $business->findAll($pageCore);
		$models = $models ? $models : array();
		$arrStype = HomeBrandAdDataModel::getStype();
		
		$this->assign('title','广告管理');
		$this->assign('models', $models);
		$this->assign('pageCore', $pageCore);
		$this->assign('arrStype', $arrStype);
	}
}
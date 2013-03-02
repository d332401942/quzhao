<?php 

class DataHomebrandView extends BaseView
{
	
	public function index()
	{
		$business = new HomeBrandBusiness();
		$pageCore = new PageCoreLib();
		$pageCore->pageSize = 10;
		if (isset($_GET['page']) && (int)$_GET['page'])
		{
			$pageCore->currentPage = (int)$_GET['page'];
		}
		$models = $business->getHomeBrandData($pageCore);
		$models = $models ? $models : array();
		$bidToModels = array();
		$homeBrandModels = $business->findAll();
		if ($homeBrandModels)
		{
			foreach ($homeBrandModels as $m)
			{
				$bidToModels[$m->id] = $m;
			}
		}
		foreach ($models as $model)
		{
			$model->BName = '未知';
			if (isset($bidToModels[$model->bid]->name))
			{
				$model->BName = $bidToModels[$model->bid]->name;
			}
		}
		
		$this->assign('title', '品牌推荐');
		$this->assign('models', $models);
		$this->assign('pageCore', $pageCore);
	}
}
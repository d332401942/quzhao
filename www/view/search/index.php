<?php 

class IndexSearchView extends BaseView
{
	
	public function index($parameters)
	{
		$this->setMeta();
		$nineModels = array();
		$dpModels = array();
		$pageCore = new PageCoreLib();
        $pageCore->currentPage = !empty($parameters['page']) ? (int)$parameters['page'] : 1;
		$pageCore->currentPage = $pageCore->currentPage ? $pageCore->currentPage : 1;
		$keyword = null;
		if (!empty($parameters['keyword']))
		{
			$keyword = trim($parameters['keyword']);
		}
        $keyword = urldecode($keyword);
		$business = new HomeTjDataBusiness();
		$models = $business->search($pageCore,$keyword);
		if ($models)
		{
			foreach ($models as $model)
			{
				if ($model->cid == 1) 
				{
					$nineModels[] = $model;
				}
				else
				{
					$dpModels[] = $model;
				}
			}
		}
		
		$this->assign('nineModels',$nineModels);
		$this->assign('dpModels',$dpModels);
		$this->assign('pageCore',$pageCore);
        $this->assign('keyword', $keyword);
	}
}
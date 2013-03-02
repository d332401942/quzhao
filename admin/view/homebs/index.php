<?php 

class IndexHomebsView extends BaseView
{
	
	public function index()
	{
		$homeBsClassBusiness = new HomeBsClassBusiness();
		$classModels = $homeBsClassBusiness->findAll();
		$classIdToModel = array();
		foreach ($classModels as $model)
		{
			$classIdToModel[$model->id] = $model;
		}
		$business = new HomeBsDataBusiness();
		$models = $business->findAll();
		foreach ($models as $model)
		{
			$model->HomeClassName = '未知';
			if (isset($classIdToModel[$model->bid]->name))
			{
				$model->HomeClassName = $classIdToModel[$model->bid]->name;
			}
		}
		$this->assign('title','合作商家');
		$this->assign('models',$models);
	}
}
<?php 

class HomeTjClassBusiness extends BaseBusiness
{
	
	public function add($model)
	{
		
		$data = new HomeTjClassData();
		$data->add($model);
	}
	
	public function updateModel($model)
	{
		$data = new HomeTjClassData();
		$data->updateModel($model);
	}
	
	/**
	 * 得到根分类的数据
	 */
	public function getRootClass()
	{
		$data = new HomeTjClassData();
		$models = $data->getRootClass();
		return $models;
	}
	
	/**
	 * 得到所有分类的数据
	 */
	public function findAll($isuse = array(HomeTjClassDataModel::IS_USE_TYPE_NO,HomeTjClassDataModel::IS_USE_TYPE_YES))
	{
		$data = new HomeTjClassData();
		$data->where(array('isuse' => array('in' => $isuse)));
		$models = $data->setOrder(array('sort' => 'desc'))->findAll();
		
		$rootModels = array();
		foreach ($models as $key => $model)
		{
			if ($model->pid == 0)
			{
				$rootModels[$model->id.'--'] = $model;
				unset($models[$key]);
			}
		}
		foreach ($models as $model)
		{
			if (!empty($rootModels[$model->pid.'--']))
			{
				$rootModels[$model->pid.'--']->children[] = $model;
			}
		}
		return array_values($rootModels);
	}
	
	/**
	 * 通过名称获取分类信息
	 */
	public function getByName($name)
	{
		$data = new HomeTjClassData();
		$result = $data->where(array('name' => $name))->findOne();
		return $result;
	}
    
    /**
	 * 得到超值单品的数据
	 */
    public function getAllDp()
	{
		$data = new HomeTjClassData();
		$data->where(array('pid' => array('=' => 2)));
		$models = $data->setOrder(array('sort' => 'desc','id'=>'desc'))->findAll();
		return $models;
	}
   
}
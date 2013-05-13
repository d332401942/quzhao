<?php

class AssociatedBusiness extends BaseBusiness
{
	
    public function update($model,$name)
	{
		$data = new AssociatedData();
		$data->update($model,$name);
	}
	
	/*
	*查询关键词
	*/
	public function getAll($pageCore,$name)
	{
		$data = new AssociatedData();
		return $data->getAll($pageCore,$name);
	}
	
	
	
	public function del($name)
	{
		$data = new AssociatedData();
		$data->del($name);
	}
	public function add($model)
	{
		$data = new AssociatedData();
		$result = $data->getOneCate($model->keyname);
		if($result)
		{
			$this->throwException('关键词已经存在');
		}
		$data->add($model);
	}
	
	/*
	*	修改查询信息
	*/
	public function getName($name)
	{
		$data = new AssociatedData();
		return $data->getOneCate($name);
	}
	/*
	*	修改关键名称
	*/
	public function updateName($model,$name)
	{
		$data = new AssociatedData();
		$result = $data->getOneCate($model->keyname);
		/*if($result)
		{
			$this->throwException('关键词已经存在');
		}*/
		$data->updateName($model,$name);
	}
	
	/*
	*	得到子分类
	*/
	public function getCate($pid, $level)
	{
		$data = new CategoryData();
		return $data->getCate($pid, $level);
	}
	
	/*
	*	得到关键词已经关联分类ID
	*/
	public function getOneCate($name)
	{
		$data = new AssociatedData();
		return $data->getSearchCateId($name);
	}


	
}

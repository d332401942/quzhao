<?php

class HomeBrandBusiness extends BaseBusiness
{
	
	public function getHomeBrandModelBy($id)
	{
		$data = new HomeBrandData();
		return $data->getOneById($id);
	}
	
	public function updateModel($model)
	{
		$data = new HomeBrandData();
		try
		{
			$data->updateModel($model);
		}
		catch (DbExceptionLib $e)
		{
			if ($e->getCode() == 23000)
			{
				$this->throwException('名称已经存在');
			}
			else
			{
				throw $e;
			}
		}
	}
	
	public function add($model)
	{
		$data = new HomeBrandData();
		try
		{
			$data->add($model);
		}
		catch (DbExceptionLib $e)
		{
			if ($e->getCode() == 23000)
			{
				$this->throwException('名称已经存在');
			}
			else
			{
				throw $e;
			}
		}
	}
	
	public function findAll($pageCore = null,$ishot = null,$name = null)
	{
		$data = new HomeBrandData();
		if ($pageCore)
		{
			$data->setPage($pageCore);
		}
		$query = array();
		if ($ishot !== null)
		{
			$query['ishot'] = $ishot;
		}
		if ($name)
		{
			$query['name'] = array('like' => '%'.$name.'%');
		}
		if ($query)
		{
			$data->where($query);
		}
		$data->setOrder(array('sort' => 'desc', 'id' => 'desc'));
		return $data->findAll();
	}
	
	/**
	 * 得到推荐信息
	 */
	public function getHomeBrandData($pageCore = null)
	{
		$data = new HomeBrandData('HomeBrandDataDataModel');
		if($pageCore)
		{
			$data->setPage($pageCore);
		}
		$data->setOrder(array('sort' => 'desc', 'id' => 'desc'));
		return $data->findAll();
	}
	
	public function getDataById($id)
	{
		$data = new HomeBrandData('HomeBrandDataDataModel');
		return $data->getOneById($id);
	}
	
	public function delData($id)
	{
		$data = new HomeBrandData('HomeBrandDataDataModel');
		$data->delById($id);
	}
	
	/**
	 * 得到热门品牌数据
	 */
	public function getHotHomeBrandModels()
	{
		$data = new HomeBrandData();
		return $data->getHotHomeBrandModels();
	}
	
	/**
	 * 得到首页品牌特卖的数据
	 */
	public function getIndexBrandDataModels()
	{
		$data = new HomeBrandData();
		return $data->getIndexBrandDataModels();
	}
	
	/**
	 * 得到首页品牌特卖的数据
	 * @param int $start 开始取
	 * @param int $end 取几条
	 */
	public function getIndexBrandData($start, $end)
	{
		$data = new HomeBrandData();
		return $data->getIndexBrandData($start, $end);
	}
}
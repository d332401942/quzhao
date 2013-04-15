<?php

class CategoryData extends BaseData
{
	
	const CACHE_KEY = 'categorymodels';

	private static $idToCategoryModels = array();
	
	public function getCompleteCategoryByIds($ids)
	{
		$allCategoryModels = $this->findAll();
		$models = array();
		foreach ($ids as $id)
		{
			if (isset($allCategoryModels[$id]))
			{
				$lastModel = $allCategoryModels[$id];
				$pid2 = $lastModel->pid2;
				$pid1 = $lastModel->pid1;
				$middleModel = $allCategoryModels[$pid2];
				$preModel = $allCategoryModels[$pid1];
				if (empty($models[$pid1]))
				{	
					$models[$pid1] = $preModel;
				}
				if (empty($preModel->children[$pid2]))
				{
					$preModel->children[$pid2] = $middleModel;
				}
				if (empty($middleModel->children[$id]))
				{
					$middleModel->children[$id] = $lastModel;
				}
			}
		}
		return $models;
	}

	public function getChildrenIds($id)
	{
		$models = $this->findAll();
		$childrenIds = array();
		foreach ($models as $model)
		{
			$pathArr = explode('-', $model->path);
			{
				if (in_array($id, $pathArr))
				{
					$childrenIds[] = $model->categoryid;
				}
			}
		}
		return $childrenIds;
	}
	
	public function findAll()
	{
		if (!empty(self::$idToCategoryModels))
		{
			return self::$idToCategoryModels;
		}
		//todo走缓存拿去
		self::$idToCategoryModels = $this->cacheFindAll();
		if (!empty(self::$idToCategoryModels))
		{
			return self::$idToCategoryModels;
		}
		
		self::$idToCategoryModels = $this->dbFindAll();
		$this->setCache();
		return self::$idToCategoryModels;
	}

	private function cacheFindAll()
	{
		$memcache = M('MemcacheDbLib');
		$json = $memcache->get(self::CACHE_KEY);
		$arr = json_decode($json, true);
		$models = array();
		if (!$arr)
		{
			return $models;
		}
		foreach ($arr as $val)
		{
			$model = new CategoryDataModel();
			foreach ($model as $k => $v)
			{
				if (isset($val[$k]))
				{
					$model->$k = $val[$k];
				}
			}
			$models[$model->categoryid] = $model;
		}
		return $models;
	}

	private function setCache()
	{
		$models = self::$idToCategoryModels;
		$memcache = M('MemcacheDbLib');
		$json = json_encode($models);
		$memcache->set(self::CACHE_KEY, $json);
	}

	private function dbFindAll()
	{
		$this->selectDb(Config::DB_MYSQL_SEARCH_HOST, Config::DB_MYSQL_USERNAME, Config::DB_MYSQL_PASSWORD, Config::DB_MYSQL_SEARCH_DBNAME, Config::DB_MYSQL_SEARCH_PORT);
		$sql = 'select categoryid,attrid,name,level,pid1,pid2,sort,isvalid';
		$sql .= ' from category where isvalid = 1 order by sort desc';
		$statement = $this->run($sql);
		$result = array();
		while ($categoryDataModel = $statement->fetchObject('CategoryDataModel'))
		{
			$path = '';
			if ($categoryDataModel->pid1)
			{
				$path .= $categoryDataModel->pid1 . '-';
			}
			if ($categoryDataModel->pid2)
			{
				$path .= $categoryDataModel->pid2 . '-';
			}
			$path .= $categoryDataModel->categoryid;
			$categoryDataModel->path = $path;
			$result[$categoryDataModel->categoryid] = $categoryDataModel;
		}
		return $result;
	}
	
	public function getAttDb($categoryId)
	{
		$this->selectDb(Config::DB_MYSQL_SEARCH_HOST, Config::DB_MYSQL_USERNAME, Config::DB_MYSQL_PASSWORD, Config::DB_MYSQL_SEARCH_DBNAME, Config::DB_MYSQL_SEARCH_PORT);
		//SELECT t1.* FROM `attrdb` as t1 INNER JOIN category as t2 on t2.attrid = t1.attrid WHERE t2.categoryid = 282
		$sql = 'select t1.attrid t2.* from category as t1 inner join attrdb as t2 on t2.attrid = t1.attrid where ';
		
	}
	

}

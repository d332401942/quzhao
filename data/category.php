<?php

class CategoryData extends BaseData
{
	
	const CACHE_KEY = 'categorymodels';
	
	const CACHE_ATTRDB_KEY = 'cache_attrdb_key';

	private static $idToCategoryModels = array();
	
	private static $attrdbModels = array();
	
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
	
	public function getAttrDbs($attrId)
	{
		if (!empty(self::$attrdbModels[$attrId]))
		{
			return self::$attrdbModels[$attrId];
		}
		
		self::$attrdbModels[$attrId] = $this->cacheAttrAll($attrId);
		
		if (!empty(self::$attrdbModels[$attrId]))
		{
			return self::$attrdbModels[$attrId];
		}
		if(!empty($attrId))
		{
			$this->selectDb(Config::DB_MYSQL_SEARCH_HOST, Config::DB_MYSQL_USERNAME, Config::DB_MYSQL_PASSWORD, Config::DB_MYSQL_SEARCH_DBNAME, Config::DB_MYSQL_SEARCH_PORT);
			$sql = "select * from attrdb  where isvalid = 1 AND  attrId = ".$attrId." order by attrdbid desc ,sort desc";
			$statement = $this->run($sql);
			while ($attrdbDataModel = $statement->fetchObject('AttrdbDataModel'))
			{
				self::$attrdbModels[$attrdbDataModel->attrid][$attrdbDataModel->attrdbid] = $attrdbDataModel;
			}
			$this->setAttrCache($attrId);
			return self::$attrdbModels[$attrId];
		}
		$result = array();
		return $result;
	}
	
	public function getAttrId($categoryId)
	{
		$this->selectDb(Config::DB_MYSQL_SEARCH_HOST, Config::DB_MYSQL_USERNAME, Config::DB_MYSQL_PASSWORD, Config::DB_MYSQL_SEARCH_DBNAME, Config::DB_MYSQL_SEARCH_PORT);
		$result = array();
		$this->setOrder(array('categoryid'=>'desc'));
		$result = $this->getOneById($categoryId);
		return  $result ;
	}
	
	private function setAttrCache($attrId)
	{
		$models = self::$attrdbModels[$attrId];
		$memcache = M('MemcacheDbLib');
		$json = json_encode($models);
		$key = self::getCacheAttrDbKey($attrId);
		$memcache->set($key, $json);
	}
	
	private static function getCacheAttrDbKey($attrId)
	{
		$key = self::CACHE_ATTRDB_KEY . $attrId;
		return $key;
	}
	
	private function cacheAttrAll($attrId)
	{
		$memcache = M('MemcacheDbLib');
		$key = self::getCacheAttrDbKey($attrId);
		$json = $memcache->get($key);
		$arr = json_decode($json, true);
		$models = array();
		if (!$arr)
		{
			return $models;
		}
		foreach ($arr as $val)
		{
			$model = new AttrdbDataModel();
			foreach ($model as $k => $v)
			{
				if (isset($val[$k]))
				{
					$model->$k = $val[$k];
				}
			}
			$models[$model->attrdbid] = $model;
		}
		return $models;
	}

}

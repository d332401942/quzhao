<?php

class CategoryData extends BaseData
{

	const CACHE_KEY = 'categorymodels';

	const CACHE_ATTRDB_KEY = 'cache_attrdb_key';
	
	const CACHE_NAME_TO_CATEGORYMODELS = 'nametocategorymodels';

	public static $categoryModels = array();

	private static $idToCategoryModels = array ();

	private static $attrdbModels = array ();

	public function getCategoryIdsByName($name)
	{
		if (!self::$categoryModels)
		{
			self::$categoryModels = $this->getCategoryIdsByNameToCache ( $name );
		}
		// 走缓存获取
		return self::$categoryModels;
	}

	private function getCategoryIdsByNameToCache($name)
	{
		$memcache = new MemcacheDbLib();
		$str = $memcache->get(self::CACHE_NAME_TO_CATEGORYMODELS . md5($name));
		$ids = json_decode($str,true);
		if ($ids)
		{
			$result = $this->getCompleteCategoryByIds($ids);
			foreach ($result as $model)
			{
				if (!in_array($model->categoryid, $ids))
				{
					$ids[] = $model->categoryid;
				}
			}
		}
		return $ids;
	}

	/**
	 * TODO
	 * 设置名称与分类对应的缓存
	 * @param unknown $name
	 * @return Ambigous <multitype:, unknown>
	 */
	public function setCacheNameToCategoryModels()
	{
		$this->selectSearchSlaveDb ();
		$categoryModels = $this->findAll();
		$result = array();
		foreach ($categoryModels as $model)
		{
			$result[$model->name][] = $model->categoryid;
		}
		$memcache = new MemcacheDbLib();
		foreach ($result as $name => $ids)
		{
			$json = json_encode($ids);
			$memcache->set ( self::CACHE_NAME_TO_CATEGORYMODELS . md5($name), $json,0, time () + 86400 );
		}
	}

	public function getCompleteCategoryByIds($ids, $categoryIdToCount = array())
	{
		$allCategoryModels = $this->findAll ();
		$models = array ();
		$levelModels = $this->getLevelModels($ids);
		/* foreach ($models as $id => $model)
		{
			
		}
		P($allCategoryModels);
		foreach ( $ids as $id )
		{
			if (isset ( $allCategoryModels [$id] ))
			{
				$model = $allCategoryModels [$id];
				if (! empty ( $categoryIdToCount [$id] ))
				{
					$model->num = $categoryIdToCount [$id];
				}
				$pid2 = $model->pid2;
				$pid1 = $model->pid1;
				if ($model->level == 3)
				{
					$lastModel = $model;
				}
				else if ($model->level == 2)
				{
					$pid2 = $model->categoryid;
				}
				else if ($model->level == 1)
				{
					$pid1 = $model->categoryid;
				}
				$middleModel = null;
				$preModel = null;
				$middleModel = ! empty ( $allCategoryModels [$pid2] ) ? $allCategoryModels [$pid2] : null;
				$preModel = ! empty ( $allCategoryModels [$pid1] ) ? $allCategoryModels [$pid1] : nul;
				if (empty ( $models [$pid1] ))
				{
					$models [$pid1] = $preModel;
				}
				if (empty ( $preModel->children [$pid2] ) && $middleModel)
				{
					$preModel->children [$pid2] = $middleModel;
				}
				if (empty ( $middleModel->children [$id] ) && $model)
				{
					$middleModel->children [$id] = $model;
				}
			}
		}
		P($models); */
		return $levelModels;
	}
	
	public function getLevelModels($needIds = array())
	{
		$allCategoryModels = $this->findAll ();
		
		$result = array();
		if ($needIds)
		{
			//$needIds = $this->getChildrenIds($needIds);
			//P($needIds);exit;
			foreach ($needIds as $id)
			{
				$thisModel = $allCategoryModels[$id];
				$pathArr = explode('-', $thisModel->path);
				$pathArr = array_reverse($pathArr);
				array_shift($pathArr);
				foreach ($pathArr as $k => $id)
				{
					$parentModel = $allCategoryModels[$id];
					$parentModel->children[$thisModel->categoryid] = $thisModel;
					$thisModel = $parentModel;
				}
				$result[$thisModel->categoryid] = $thisModel;
			}
		}
		else
		{
			foreach ($allCategoryModels as $model)
			{
				$pathArr = array();
				$pathArr = explode('-', $model->path);
				$pathArr = array_reverse($pathArr);
				foreach ($pathArr as $k => $id)
				{
					$parentModel = $allCategoryModels[$id];
					$parentModel->children[$model->categoryid] = $model;
					$model = $parentModel;
				}
				$result[$model->categoryid] = $model;
			}
		}
		return $result;
	}

	public function getChildrenIds($id)
	{
		$ids = is_array ( $id ) ? $id : array (
						$id 
		);
		$models = $this->findAll ();
		$childrenIds = array ();
		foreach ( $models as $model )
		{
			$pathArr = explode ( '-', $model->path );
			{
				foreach ( $ids as $id )
				{
					if (in_array ( $id, $pathArr ))
					{
						$childrenIds [] = $model->categoryid;
					}
				}
			}
		}
		return $childrenIds;
	}

	public function findAll()
	{
		if (! empty ( self::$idToCategoryModels ))
		{
			return self::$idToCategoryModels;
		}
		// todo走缓存拿去
		self::$idToCategoryModels = $this->cacheFindAll ();
		if (! empty ( self::$idToCategoryModels ))
		{
			return self::$idToCategoryModels;
		}
		
		self::$idToCategoryModels = $this->dbFindAll ();
		$this->setCache ();
		return self::$idToCategoryModels;
	}

	/**
	 * 重新设置分类缓存
	 */
	public function resetCache()
	{
		self::$idToCategoryModels = $this->dbFindAll ();
		$this->setCache ();
		$this->setCacheNameToCategoryModels();
	}

	private function cacheFindAll()
	{
		$memcache = M ( 'MemcacheDbLib' );
		$json = $memcache->get ( self::CACHE_KEY );
		$arr = json_decode ( $json, true );
		$models = array ();
		if (! $arr)
		{
			return $models;
		}
		foreach ( $arr as $val )
		{
			$model = new CategoryDataModel ();
			foreach ( $model as $k => $v )
			{
				if (isset ( $val [$k] ))
				{
					$model->$k = $val [$k];
				}
			}
			$models [$model->categoryid] = $model;
		}
		return $models;
	}

	private function setCache()
	{
		$models = self::$idToCategoryModels;
		$memcache = M ( 'MemcacheDbLib' );
		$json = json_encode ( $models );
		$memcache->set ( self::CACHE_KEY, $json,0, time () + 86400 );
	}

	private function dbFindAll()
	{
		$this->selectSearchSlaveDb ();
		$sql = 'select categoryid,attrid,name,level,pid1,pid2,sort,isvalid';
		$sql .= ' from category where isvalid = 1 order by categoryid desc,sort desc';
		$statement = $this->run ( $sql );
		$result = array ();
		while ( $categoryDataModel = $statement->fetchObject ( 'CategoryDataModel' ) )
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
			$result [$categoryDataModel->categoryid] = $categoryDataModel;
		}
		return $result;
	}

	public function getAttrDbs($attrId)
	{
		if (! empty ( self::$attrdbModels [$attrId] ))
		{
			return self::$attrdbModels [$attrId];
		}
		
		self::$attrdbModels [$attrId] = $this->cacheAttrAll ( $attrId );
		
		if (! empty ( self::$attrdbModels [$attrId] ))
		{
			return self::$attrdbModels [$attrId];
		}
		if (! empty ( $attrId ))
		{
			$this->selectSearchSlaveDb ();
			$sql = "select * from attrdb  where isvalid = 1 AND  attrId = " . $attrId . " order by attrdbid asc ,sort desc";
			$statement = $this->run ( $sql );
			while ( $attrdbDataModel = $statement->fetchObject ( 'AttrdbDataModel' ) )
			{
				self::$attrdbModels [$attrdbDataModel->attrid] [$attrdbDataModel->attrdbid] = $attrdbDataModel;
			}
			$this->setAttrCache ( $attrId );
			return self::$attrdbModels [$attrId];
		}
		$result = array ();
		return $result;
	}

	public function getAttrId($categoryId)
	{
		$this->selectSearchSlaveDb ();
		$result = array ();
		$this->setOrder ( array (
						'categoryid' => 'asc' 
		) );
		$result = $this->getOneById ( $categoryId );
		return $result;
	}

	/**
	 * 根据品牌ID获取品牌
	 *
	 * @param unknown $brandIds        	
	 * @return multitype:
	 */
	public function getSearchBrandDataModel($brandIds)
	{
		$this->selectSearchSlaveDb ();
		$sql = 'select * from brand where brandid in (' . implode ( ',', $brandIds ) . ')';
		$models = $this->query ( $sql, 'SearchBrandDataModel' );
		return $models;
	}

	/**
	 * 根据品牌ID获取一个品牌
	 * 
	 * @param unknown $barndId        	
	 */
	public function getSearchOneBrandDataModel($barndId)
	{
		$sql = 'select * from brand where brandid = ' . ( int ) $barndId;
		$model = $this->queryOne ( $sql, 'SearchBrandDataModel' );
		return $model;
	}

	private function setAttrCache($attrId)
	{
		$models = self::$attrdbModels [$attrId];
		$memcache = M ( 'MemcacheDbLib' );
		$json = json_encode ( $models );
		$key = self::getCacheAttrDbKey ( $attrId );
		$memcache->set ( $key, $json );
	}

	private static function getCacheAttrDbKey($attrId)
	{
		$key = self::CACHE_ATTRDB_KEY . $attrId;
		return $key;
	}

	private function cacheAttrAll($attrId)
	{
		$memcache = M ( 'MemcacheDbLib' );
		$key = self::getCacheAttrDbKey ( $attrId );
		$json = $memcache->get ( $key );
		$arr = json_decode ( $json, true );
		$models = array ();
		if (! $arr)
		{
			return $models;
		}
		foreach ( $arr as $val )
		{
			$model = new AttrdbDataModel ();
			foreach ( $model as $k => $v )
			{
				if (isset ( $val [$k] ))
				{
					$model->$k = $val [$k];
				}
			}
			$models [$model->attrdbid] = $model;
		}
		return $models;
	}

	public function getAll($pageCore, $level)
	{
		$this->selectSearchSlaveDb ();
		/*
		 * 分页 $sql = "select count(*) as num from category where level = $lev"; $res = $this->query($sql); $pageCore->count = $res [0] ['num']; $pageCore->pageCount = ceil ( $pageCore->count / $pageCore->pageSize );
		 */
		$sql = 'select * from category where level = ' . $level . ' order by sort asc ';
		$result = $this->query ( $sql, 'CategoryDataModel' );
		return $result;
	}

	/**
	 * 得到所有分类，导出的时候用,临时方法
	 */
	/*
	 * public function getSy() { $this->selectSearchSlaveDb(); //$result = $this->findAll(); $sql = 'select categoryid,name from category where categoryid < 5000 and level = 3 order by categoryid asc'; $result = $this->query($sql,'CategoryDataModel'); return $result; } public function getSy3() { $this->selectSearchSlaveDb(); //$result = $this->findAll(); $sql = 'select categoryid,name,pid1,pid2 from category where categoryid >= 5000 and level = 3 order by categoryid asc'; $result = $this->query($sql,'CategoryDataModel'); return $result; } public function getSy2() { $this->selectSearchSlaveDb(); //$result = $this->findAll(); $sql = 'select categoryid,name,pid1,pid2 from category where categoryid >= 5000 and level = 2 order by categoryid asc'; $result = $this->query($sql,'CategoryDataModel'); return $result; } public function getSy1() { $this->selectSearchSlaveDb(); //$result = $this->findAll(); $sql = 'select categoryid,name,pid1,pid2 from category where categoryid >= 5000 and level = 1 order by categoryid asc'; $result = $this->query($sql,'CategoryDataModel'); return $result; }
	 */
	public function getCate($pid, $level)
	{
		$pidStr = 'pid' . ($level - 1);
		$this->selectSearchSlaveDb ();
		$sql = 'select * from category  where level = ' . ($level) . ' and ' . $pidStr . ' = ' . $pid . ' order by sort asc';
		return $this->query ( $sql, 'CategoryDataModel' );
	}

	public function getCateName($id)
	{
		$id = trim ( $id, ',' );
		$this->selectSearchSlaveDb ();
		$sql = 'select * from category where categoryid in(' . $id . ') order by sort asc,level asc';
		$result = $this->query ( $sql, 'CategoryDataModel' );
		return $result;
	}

}

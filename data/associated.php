<?php

class AssociatedData extends BaseData
{

	public function update($model,$name)
	{
		$this->selectSearchMasterDb();
		$sql = "update s_key set categoryids = '".$model->categoryids."' where keyname = '".$name."' ";
		$this->exec($sql);
	}
	
	/*
	*	修改关键名称
	*/
	public function updateName($model,$name)
	{
		$this->selectSearchMasterDb();
		$sql = "update s_key set keyname = '".$model->keyname."' where keyname = '".$name."' ";
		$this->exec($sql);
	}
	
	public function getAll($pageCore,$name = false)
	{
		if($name)
		{
			$this->selectSearchMasterDb();
			$sql = "select count(*) as num from s_key where keyname like '%$name%'";
			$res = $this->query($sql);
			$pageCore->count = $res [0] ['num'];
			$pageCore->pageCount = ceil ( $pageCore->count / $pageCore->pageSize );
			//TODO 索引
			$sql = "select * from s_key where keyname like '%$name%' limit " . ($pageCore->currentPage - 1) * $pageCore->pageSize . ',' . $pageCore->pageSize;
			$result = $this->query($sql,'AssociatedDataModel');
			return $result;
		}
		return array();		
	}
	
	public function getKeyname($name)
	{
		$this->selectSearchMasterDb();
		$sql = "select * from s_key where keyname = '$name' ";
		$result = $this->query($sql,'AssociatedDataModel');
		$result = array_pop($result);
		return $result;
	}
	
	public function del($name)
	{
		$this->selectSearchMasterDb();
		$sql = "delete from s_key  where keyname = '".$name."' ";
		echo $sql;
		$this->exec($sql);
	}
	
	public function getOneCate($name)
	{
		$this->selectSearchMasterDb();
		$this->where(array('keyname'=>$name));
		$result = $this->findOne();
		return $result;
	}
	/**
	*前台搜索获取分类ID
	*/
	private static $cateIdModels = array();
	const CATE_ID_CACHE = 'cate_id_cache';
	public function getSearchCateId($name)
	{
		if(!empty(self::$cateIdModels))
		{
			return self::$cateIdModels[$name];
		}
		
		self::$cateIdModels[$name] = $this->getCateIdModels($name);
		if(!empty(self::$cateIdModels))
		{
			return self::$cateIdModels[$name];
		}
		
		$this->selectSearchSlaveDb();
		$this->where(array('keyname'=>$name));
		$result = $this->findOne();
		self::$cateIdModels [$name] = $result;
		$this->setCateIdModels($name);
		return $result;
	}
	
	/*
	 *	查询前台搜索分类ID缓存
	 */
	private function  getCateIdModels($name)
	{
		$memcache = M ( 'MemcacheDbLib' );
		$json = $memcache->set(CATE_ID_CACHE.$name);
		$data = json_decode($json,true);
		return $data;
	}
	
	/*
	 *	设置前台搜索分类ID缓存
	 */
	 private function setCateIdModels($name)
	 {
		$data = self::$cateIdModels[$name];
		$value = json_ecode($data);
		$memcache = M ( 'MemcacheDbLib' );
		$memcache->set(CATE_ID_CACHE.$name, $value);
	 }
}

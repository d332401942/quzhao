<?php

class AssociatedData extends BaseData
{

	public function update($model,$name)
	{
		$this->selectDb(Config::DB_MYSQL_SEARCH_HOST, Config::DB_MYSQL_USERNAME, Config::DB_MYSQL_PASSWORD, Config::DB_MYSQL_SEARCH_DBNAME, Config::DB_MYSQL_SEARCH_PORT);
		$sql = "update s_key set categoryids = '".$model->categoryids."' where keyname = '".$name."' ";
		$this->exec($sql);
	}
	
	/*
	*	修改关键名称
	*/
	public function updateName($model,$name)
	{
		$this->selectDb(Config::DB_MYSQL_SEARCH_HOST, Config::DB_MYSQL_USERNAME, Config::DB_MYSQL_PASSWORD, Config::DB_MYSQL_SEARCH_DBNAME, Config::DB_MYSQL_SEARCH_PORT);
		$sql = "update s_key set keyname = '".$model->keyname."' where keyname = '".$name."' ";
		$this->exec($sql);
	}
	
	public function getAll($pageCore,$name = false)
	{
		if($name)
		{
			$this->selectDb(Config::DB_MYSQL_SEARCH_HOST, Config::DB_MYSQL_USERNAME, Config::DB_MYSQL_PASSWORD, Config::DB_MYSQL_SEARCH_DBNAME, Config::DB_MYSQL_SEARCH_PORT);
			$sql = "select count(*) as num from s_key where keyname like '%$name%'";
			$res = $this->query($sql);
			$pageCore->count = $res [0] ['num'];
			$pageCore->pageCount = ceil ( $pageCore->count / $pageCore->pageSize );
			
			$sql = "select * from s_key where keyname like '%$name%' limit " . ($pageCore->currentPage - 1) * $pageCore->pageSize . ',' . $pageCore->pageSize;
			$result = $this->query($sql,'AssociatedDataModel');
			return $result;
		}
		return array();		
	}
	
	public function getKeyname($name)
	{
		$this->selectSearchSlaveDb();
		$sql = "select * from s_key where keyname = '$name' ";
		$result = $this->query($sql,'AssociatedDataModel');
		$result = array_pop($result);
		return $result;
	}
	
	public function del($name)
	{
		$this->selectSearchMasterDb();
		$sql = "delete from s_key  where keyname = '".$name."' ";
		$this->exec($sql);
	}
	
	public function getOneByName($name)
	{
		$this->selectSearchSlaveDb();
		$this->where(array('keyname'=>$name));
		return $this->findOne();
	}
	
	public function getOneCate($name)
	{
		$this->selectDb(Config::DB_MYSQL_SEARCH_HOST, Config::DB_MYSQL_USERNAME, Config::DB_MYSQL_PASSWORD, Config::DB_MYSQL_SEARCH_DBNAME, Config::DB_MYSQL_SEARCH_PORT);
		$this->where(array('keyname'=>$name));
		return $this->findOne();
	}
}

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
	
	/*
	*	得到数据原有分类
	*/
	public function getKeyname($name)
	{
		$data = new AssociatedData();
		return $data->getKeyname($name);
	}
	
	public function del($name)
	{
		$data = new AssociatedData();
		$data->del($name);
	}
	public function add($model)
	{
		$data = new AssociatedData();
		$data->selectDb(Config::DB_MYSQL_SEARCH_HOST, Config::DB_MYSQL_USERNAME, Config::DB_MYSQL_PASSWORD, Config::DB_MYSQL_SEARCH_DBNAME, Config::DB_MYSQL_SEARCH_PORT);
		$data->add($model);
	}
}

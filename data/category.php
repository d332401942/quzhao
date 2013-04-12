<?php

class CategoryData extends BaseData
{
	
	public function findAll()
	{
		$this->selectDb(Config::DB_MYSQL_SEARCH_HOST, Config::DB_MYSQL_USERNAME, Config::DB_MYSQL_PASSWORD, Config::DB_MYSQL_SEARCH_DBNAME, Config::DB_MYSQL_SEARCH_PORT);
		//$this->setLine(array('name'));
		$result = parent::findAll();
		P($result);
	}
	

}

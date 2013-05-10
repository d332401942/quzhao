<?php

class BaseData extends HandleMysqlDbLib
{

	public function selectSearchMasterDb()
	{
		$this->selectDb ( 
					Config::DB_MYSQL_SEARCH_MASTER_HOST,
				 	Config::DB_MYSQL_USERNAME,
				 	Config::DB_MYSQL_PASSWORD, 
				 	Config::DB_MYSQL_SEARCH_DBNAME,
				 	Config::DB_MYSQL_SEARCH_MASTER_PORT 
				);
	}

	public function selectSearchSlaveDb()
	{
		$this->selectDb (
				Config::DB_MYSQL_SEARCH_SLAVE_HOST,
				Config::DB_MYSQL_USERNAME,
				Config::DB_MYSQL_PASSWORD,
				Config::DB_MYSQL_SEARCH_DBNAME,
				Config::DB_MYSQL_SEARCH_SLAVE_PORT
		);
	}

}
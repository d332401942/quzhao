<?php

class AssociatedData extends BaseData
{

	public function addReply($model)
	{
		$this->add ( $model );
	}
	
	public function getAll($pageCore,$name)
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
}

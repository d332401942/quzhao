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
}

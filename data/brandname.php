<?php

class BrandnameData extends BaseData
{
 
	public function getAll($pageCore,$name=false)
	{
		if($name)
		{
			$this->where(array('name'=>array('='=>$name)));
		}
		$this->setOrder(array('id'=>'desc'));
		$this->setPage($pageCore);
		return $this->findAll();
	}
	
	public function delMsg($id)
	{
		$ids = is_array($id) ? $id : array($id);
		$sql = 'delete from brand where brand_name_id in ('.implode(',', $ids).')';
		$this->exec($sql);
		$sql = 'delete from brand_name where id in ('.implode(',', $ids).')';
		$this->exec($sql);
	}
}




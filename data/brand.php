<?php

class BrandData extends BaseData
{
    public function getAll()
	{
		$sql = 'select t1.*,t2.name as cateName,t3.username as username from brand as t1 join brand_cate as t2 on t2.id = t1.cate join brandadmin as t3 on t3.id = t1.userid';
		$result = $this->query($sql,'BrandDataModel');
		//P($result);exit;
		return $result;
	}
	
	public function delMsg($id)
	{
		$ids = is_array($id) ? $id : array($id);
		$sql = 'delete from brand where id in ('.implode(',', $ids).')';
		$this->exec($sql);
	}
}


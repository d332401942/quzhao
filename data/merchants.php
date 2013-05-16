<?php
class MerchantsData extends BaseData
{
	public function getAll($state = false)
	{
		if($state)
		{
			//得到有数据的商家
			$sql = 'select DISTINCT(name),t1.* from merchants as t1 join brand as t2 on t1.id = t2.merchantsId where t2.state = 1 and end_time > '.time().' order by sort asc,id desc';
			return $this->query($sql,'MerchantsDataModel');
		}
		$this->setOrder(array('sort'=>'asc','id'=>'desc'));
		return $this->findAll();
		
	}
	
	public function del($id)
	{
		$sql = 'delete from merchants where id = '. $id;
		$this->exec($sql);
	}
    
}

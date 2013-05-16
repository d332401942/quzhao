<?php
class MerchantsData extends BaseData
{
	public function getAll()
	{
		//$data->setOrder(array('sort'=>'asc','id'=>'desc'));
		//return $data->findAll();
		
		//得到有数据的商家
		$sql = 'select DISTINCT(name),t1.* from merchants as t1 join brand as t2 on t1.id = t2.merchantsId order by sort asc,id desc';
		return $this->query($sql,'MerchantsDataModel');
	}
	
	public function del($id)
	{
		$sql = 'delete from merchants where id = '. $id;
		$data->exec($sql);
	}
    
}

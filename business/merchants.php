<?php

class MerchantsBusiness extends BaseBusiness
{

	public function add($model)
	{
		$data = M('MerchantsData');
		$data->add($model);
	}
	
	public function getAll()
	{
		$data = M('MerchantsData');
		return $data->findAll();
	}
	
	public function del($id)
	{
		$data = M('MerchantsData');
		$sql = 'delete from merchants where id = '. $id;
		$data->exec($sql);
	}
	
	public function update($model)
	{
		$data = M('MerchantsData');
		$data->updateModel($model);
	}
	
	public function getOneById($cid)
	{
		$data = M('MerchantsData');
		return $data->getOneById($cid);
	}
	
	
	
}

<?php

class MerchantsBusiness extends BaseBusiness
{

	public function add($model)
	{
		$data = M('MerchantsData');
		$data->add($model);
	}
	
	public function getAll($state = 0)
	{
		$data = M('MerchantsData');
		return $data->getAll($state);
	}
	
	public function del($id)
	{
		$data = M('MerchantsData');
		$data->del($id);
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

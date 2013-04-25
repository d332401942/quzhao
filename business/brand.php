<?php
class BrandBusiness extends BaseBusiness
{
	public function add($model)
	{
		$data = M('BrandData');
		$data->add($model);
	}
	
	public function update($model)
	{
		$data = M('BrandData');
		$data->updateModel($model);
	}
	
	public function getAll()
	{
		$data = M('BrandData');
		return $data->getAll();
	}
	
	/*
	*删除
	*/
	public function deleteBrand($ids)
	{
		$data = new BrandData();
		$data->delMsg($ids);
	}
	
	public function getOneId($id)
	{
		$data = new BrandData();
		return $data->getOneById($id);
	}
}

?>
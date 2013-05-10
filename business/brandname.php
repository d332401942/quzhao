<?php
class BrandnameBusiness extends BaseBusiness
{
	public function add($model)
	{
		$data = M('BrandnameData');
		$data->add($model);
	}
	
	public function update($model)
	{
		$data = M('BrandnameData');
		$data->updateModel($model);
	}
	public function getKeywords($keywords)
	{
		$data = M('BrandnameData');
		$sql = "select * from brand_name where name like '%".$keywords."%'";
		$result = $data->query($sql,'BrandnameDataModel');
		return $result;
	}
	
	public function checkname($name)
	{
		$data = M('BrandnameData');
		$sql = "select * from brand_name where name = '".$name."'";
		$result = $data->query($sql,'BrandnameDataModel');
		return $result;
	}
	
	public function getAll($pageCore,$name)
	{
		$data = M('BrandnameData');
		return $data->getAll($pageCore,$name);
	}
	
	public function getId($id)
	{
		$data = M('BrandnameData');
		return $data->getOneById($id);
	}
	/*
	*删除
	*/
	public function deleteBrand($ids)
	{
		$data = M('BrandnameData');
		$data->delMsg($ids);
	}
}

?>
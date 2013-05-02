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
	
	public function getAll($pageCore)
	{
		$data = M('BrandData');
		return $data->getAll($pageCore);
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
		return $data->getOne($id);
	}
	
	public function getKeywords($keywords)
	{
		$data = new BrandData();
		$sql = "select DISTINCT name from brand where name like '%".$keywords."%'";
		$result = $data->query($sql,'BrandDataModel');
		return $result;
	}
}

?>
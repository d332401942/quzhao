<?php
class BrandnameBusiness extends BaseBusiness
{
	public function add($model)
	{
		$data = M('BrandnameData');
		$data->add($model);
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
}

?>
<?php
class Brand_columnBusiness extends BaseBusiness
{
	public function add($model)
	{
		$data = M('Brand_columnData');
		$data->add($model);
	}
	
	public function update($model)
	{
		$data = M('Brand_columnData');
		$data->updateModel($model);
	}
	public function del($brandid)
	{
		$data = M('Brand_columnData');
		$sql = 'delete from brand_column where brandid = '.$brandid;
		$data->exec($sql);
	}
}

?>
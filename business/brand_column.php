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
}

?>
<?php
class Brand_cateBusiness extends BaseBusiness
{
	public function getAll()
	{
		$data = M('Brand_cateData');
		$data->setOrder(array('id'=>'desc'));
		return $data->findAll();
	}
}

?>
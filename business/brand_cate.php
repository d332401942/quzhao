<?php
class Brand_cateBusiness extends BaseBusiness
{
	public function getAll()
	{
		$data = M('Brand_cateData');
		$data->setOrder(array('id'=>'desc'));
		return $data->findAll();
	}
	
	public function add($model)
	{
		$data = M('Brand_cateData');
		$data->add($model);
	}
	
	public function del($id)
	{
		$data = M('Brand_cateData');
		$sql = 'delete from brand_cate where id = '. $id;
		$data->exec($sql);
	}
}

?>
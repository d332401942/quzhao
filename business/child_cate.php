<?php
class Child_cateBusiness extends BaseBusiness
{
	public function getAll($cateid)
	{
		$data = M('Child_cateData');
		$data->setOrder(array('id'=>'desc'));
		$data->where(array('brand_cate_id'=>array('='=>$cateid)));
		return $data->findAll();
	}
	
	public function getAllCate()
	{
		$data = M('Child_cateData');
		$sql = 'select t1.*,t2.name as cate from child_cate as t1 inner join brand_cate as t2 on t2.id = t1.brand_cate_id order by id desc';
		$result = $data->query($sql,'Child_cateDataModel');
		return $result;
	}
	
	public function add($model)
	{
		$data = M('Child_cateData');
		$data->add($model);
	}
	
	public function del($id)
	{
		$data = M('Brand_cateData');
		$sql = 'delete from child_cate where id = '. $id;
		$data->exec($sql);
	}
}

?>